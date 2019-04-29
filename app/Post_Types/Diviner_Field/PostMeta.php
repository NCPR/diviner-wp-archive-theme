<?php


namespace Diviner\Post_Types\Diviner_Field;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;

/**
 * Class Post Meta
 *
 * @package Diviner\Post_Types\Diviner_Field
 */
class PostMeta {

	const CONTAINER_FIELDS = 'div_container_fields';

	const FIELD_ACTIVE = 'div_field_active';
	const FIELD_CHECKBOX_VALUE = '1';
	const FIELD_TYPE = 'div_field_type';

	const FIELD_ID = 'div_field_id';

	const FIELD_BROWSE_HELPER_TEXT = 'div_field_browse_helper';
	const FIELD_ADMIN_HELPER_TEXT  = 'div_field_admin_helper';
	const FIELD_BROWSE_PLACEMENT   = 'div_field_browse_placement';
	const FIELD_BROWSE_DISPLAY     = 'div_field_display';
	const FIELD_BROWSE_IS_SORTABLE = 'div_field_browse_sortable';
	const FIELD_BROWSE_IS_ELASTIC  = 'div_field_browse_elastic';

	const FIELD_IS_DEFAULT     = 'div_field_default';

	const FIELD_CPT_LABEL = 'div_field_cpt_label';
	const FIELD_CPT_ID = 'div_field_cpt_id';
	const FIELD_CPT_SLUG = 'div_field_cpt_slug';

	const FIELD_TAXONOMY_SLUG = 'div_field_taxonomy_slug';
	const FIELD_TAXONOMY_SINGULAR_LABEL = 'div_field_taxonomy_sing_label';
	const FIELD_TAXONOMY_PLURAL_LABEL = 'div_field_taxonomy_plural_label';
	const FIELD_TAXONOMY_TYPE = 'div_field_taxonomy_type';
	const FIELD_TAXONOMY_TYPE_TAG = 'div_field_taxonomy_type_tag';
	const FIELD_TAXONOMY_TYPE_CATEGORY= 'div_field_taxonomy_type_category';
	const FIELD_TAXONOMY_TYPE_OPTIONS = [
		self::FIELD_TAXONOMY_TYPE_TAG  => 'Tag',
		self::FIELD_TAXONOMY_TYPE_CATEGORY   => 'Category'
	];

	const FIELD_SELECT_OPTIONS        = 'div_field_select_options';
	const FIELD_SELECT_OPTIONS_LABEL  = 'div_field_select_options_label';
	const FIELD_SELECT_OPTIONS_VALUE  = 'div_field_select_options_value';

	const FIELD_DATE_TYPE      = 'div_field_date_type';
	const FIELD_DATE_TYPE_CENTURY = 'div_field_date_type_century';
	const FIELD_DATE_TYPE_DECADE = 'div_field_date_type_decade';
	const FIELD_DATE_TYPE_YEAR = 'div_field_date_type_year';
	const FIELD_DATE_TYPE_TWO_DATE = 'div_field_date_type_two_date';
	const FIELD_DATE_TYPE_OPTIONS = [
		self::FIELD_DATE_TYPE_CENTURY  => 'Century Slider',
		self::FIELD_DATE_TYPE_DECADE   => 'Decade Slider',
		self::FIELD_DATE_TYPE_YEAR  => 'Year Slider',
		self::FIELD_DATE_TYPE_TWO_DATE  => 'Two Date Selector'
	];

	const FIELD_DATE_START = 'div_field_date_start';
	const FIELD_DATE_END = 'div_field_date_end';

	const PLACEMENT_OPTIONS_NONE = 'none';
	const PLACEMENT_OPTIONS_TOP = 'top';
	const PLACEMENT_OPTIONS_LEFT = 'left';
	const PLACEMENT_OPTIONS = [
		self::PLACEMENT_OPTIONS_NONE  => 'None',
		self::PLACEMENT_OPTIONS_TOP   => 'Top',
		self::PLACEMENT_OPTIONS_LEFT  => 'Left'
	];

	protected $container;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 2, 0 );
	}

	/*
	 *
	 * Adds the necessary field fields (confused yet?)
	 *
	 * @hook carbon_fields_register_fields
	 */
	public function add_post_meta() {

		$fields = [
			$this->get_field_types(),
			$this->get_field_active(),
			$this->get_field_browser_helper_text(),
			$this->get_field_browser_placement(),
			$this->get_field_display_popup(),
			$this->get_field_is_sortable(),
			$this->get_field_admin_helper_text(),
			$this->get_field_id(),
		];

		if ( defined( 'EP_VERSION' ) ) { // only add elastic if elastic press plugin is available
			$fields[] = $this->get_field_is_elastic();
		}

		$this->container = Container::make( 'post_meta', __( 'Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( $fields )
			->set_priority( 'high' );

		// if on edit screen of the diviner field CPT check the field type
		// have to use this approach because this function is called both on edit and new
		$is_admin_on_edit_page = $this->is_edit_page();
		$field_type = NULL;
		if ($is_admin_on_edit_page) {
			if (isset($_GET['post'])) { // on edit page
				if (get_post_type( $_GET['post'] ) === Diviner_Field::NAME) {
					$field_type = $this->get_field_type($_GET['post']);
				}
			} else {
				if (isset($_GET['field_type'])) {
					$field_type = $_GET['field_type'];
				}
			}
		}

		$this->container = Container::make( 'post_meta', __( 'Hidden Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( [
				$this->get_field_is_custom(),
			] )
			->set_priority( 'low' );

		$date_required = ( $field_type === Date_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Date Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( [
				$this->get_field_date_type($date_required),
				$this->get_field_date_start($date_required),
				$this->get_field_date_end($date_required),
			] )
			->set_priority( 'low' );

		$taxonomy_required = ( $field_type === Taxonomy_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Taxonomy Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( [
				$this->get_field_taxonomy_type($taxonomy_required),
				$this->get_field_taxonomy_singular_label($taxonomy_required),
				$this->get_field_taxonomy_plural_label($taxonomy_required),
				$this->get_field_taxonomy_slug($taxonomy_required),
			] )
			->set_priority( 'low' );

		$cpt_required = ( $field_type === CPT_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Custom Post Type Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( [
				$this->get_field_cpt_id($cpt_required),
				$this->get_field_cpt_label($cpt_required),
				$this->get_field_cpt_slug($cpt_required),
			] )
			->set_priority( 'low' );

		$select_required = ( $field_type === Select_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Select Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( [
				$this->get_field_select_options($select_required),
			] )
			->set_priority( 'low' );

	}

	public function get_current_field_type_if_in_admin() {
		if (!$this->is_edit_page()) {
			return;
		}

		global $typenow;
		if ($this->is_edit_page('edit') && $typenow === Diviner_Field::NAME ) {
			// hold on to current type if we're in the admin setting
			if (isset($_GET['post']) && !empty($_GET['post'])) {
				$post_id = $_GET['post'];
				return carbon_get_post_meta( $post_id,static::FIELD_TYPE);
			}
		} else {
			// on add page
			if ( !empty( $_GET[ 'field_type' ] ) ) {
				return $_GET[ 'field_type' ];
			}
		}
	}

	function is_edit_page($new_edit = null){
		global $pagenow;
		//make sure we are on the backend
		if (!is_admin()) return false;

		switch ($new_edit) {
			case "edit":
				return in_array( $pagenow, [ 'post.php' ] );
				break;
			case "new":
				return in_array( $pagenow, [ 'post-new.php' ] );
				break;
			default:
				return in_array( $pagenow, [ 'post.php', 'post-new.php' ] );
				break;
		}
	}

	public function get_field_select_options($required = false) {
		return Field::make( 'complex', static::FIELD_SELECT_OPTIONS, __( 'Select Options', 'ncpr-diviner' ) )
			->add_fields( $this->get_field_select_option_fields($required) );
	}

	public function get_field_select_option_fields($required = false) {
		$args = [];
		$args[] = Field::make( 'text', static::FIELD_SELECT_OPTIONS_VALUE, __( 'Value', 'ncpr-diviner' ) )
			->set_help_text( __( 'Use only lower case and underscores. No spaces. Used in the URL for facets search', 'ncpr-diviner' ) )
			->set_required( $required );
		$args[] = Field::make( 'text', static::FIELD_SELECT_OPTIONS_LABEL, __( 'Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'Appears in the dropdown', 'ncpr-diviner' ) )
			->set_required( $required );
		return $args;
	}

	public function get_field_cpt_id($required = false) {
		return Field::make( 'text', static::FIELD_CPT_ID, __( 'Custom Post Type ID (use only lower case with underscores)', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_cpt_label($required = false) {
		return Field::make( 'text', static::FIELD_CPT_LABEL, __( 'Custom Post Label', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_cpt_slug($required = false) {
		return Field::make( 'text', static::FIELD_CPT_SLUG, __( 'Custom Post Slug (use only lower case with dashes)', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_slug($required = false) {
		return Field::make( 'text', static::FIELD_TAXONOMY_SLUG, __( 'Taxonomy Slug', 'ncpr-diviner' ) )
			->set_help_text( __( 'Must be lowercase and dashes only (ex: types-of-work)', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_singular_label($required = false) {
		return Field::make( 'text', static::FIELD_TAXONOMY_SINGULAR_LABEL, __( 'Singular Taxonomy Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'ex: Type of Work', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_plural_label($required = false) {
		return Field::make( 'text', static::FIELD_TAXONOMY_PLURAL_LABEL, __( 'Plural Taxonomy Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'ex: Types of Work', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_type($required = false) {
		return Field::make( 'select', static::FIELD_TAXONOMY_TYPE, __( 'Type of taxonomy field', 'ncpr-diviner' ) )
			->add_options( static::FIELD_TAXONOMY_TYPE_OPTIONS )
			->set_help_text( __( 'Tag or category', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_start($required = false) {
		return Field::make( 'date', static::FIELD_DATE_START, __( 'Start Date of Slider', 'ncpr-diviner' ) )
			->set_help_text( __( 'If type is century, start date rounds down to nearest century. If type if decade, start date rounds to nearest decade. Only uses year.', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_end($required = false) {
		return Field::make( 'date', static::FIELD_DATE_END, __( 'End Date of Slider', 'ncpr-diviner' ) )
			->set_help_text( __( 'If type is century, end date rounds down to nearest century. If type if decade, end date rounds to nearest decade. Only uses year.', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_type($required = false) {
		return Field::make( 'select', static::FIELD_DATE_TYPE, __( 'Type of date field', 'ncpr-diviner' ) )
			->add_options( static::FIELD_DATE_TYPE_OPTIONS )
			->set_help_text( __( 'Century slider, Decade slider, Year slider, and two date min max selector', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_is_custom($required = false) {
		return Field::make( 'checkbox', static::FIELD_IS_DEFAULT, __( 'Is Default Field', 'ncpr-diviner' ) )
			->set_option_value( static::FIELD_CHECKBOX_VALUE )
			->set_required( false );
	}

	public function get_field_types() {
		$types = [
			Text_Field::NAME => Text_Field::TITLE,
			Date_Field::NAME => Date_Field::TITLE,
			Related_Field::NAME => Related_Field::TITLE,
			Taxonomy_Field::NAME => Taxonomy_Field::TITLE,
			Select_Field::NAME => Select_Field::TITLE,
			CPT_Field::NAME => CPT_Field::TITLE,
		];
		$field =  Field::make( 'select', static::FIELD_TYPE, __( 'Type of field', 'ncpr-diviner' ) )
			->set_classes( static::FIELD_TYPE )
			->add_options($types)
			->set_help_text( __( 'What kind of field is this', 'ncpr-diviner' ) );

		if ( !empty( $_GET[ 'field_type' ] ) ) {
			$default_value = $_GET[ 'field_type' ];
			$field->set_default_value( $default_value );
		}
		return $field;
	}

	public function get_field_type( $id = null) {
		if (empty($id)) {
			$id = get_the_ID();
		}
		$type = Diviner_Field::get_field_post_meta( $id, PostMeta::FIELD_TYPE );
		if ( ! empty($type) ) {
			return $type;
		}
		if ( !empty( $_GET[ 'field_type' ] ) ) {
			return $_GET[ 'field_type' ];
		}
		return null;
	}

	public function get_field_id() {
		$field = Field::make( 'text', static::FIELD_ID, __( 'Field ID (for reference only)', 'ncpr-diviner' ) )
			->set_required( true )->set_classes( static::FIELD_ID );

		$id = Diviner_Field::get_field_post_meta( get_the_ID(), PostMeta::FIELD_ID );

		if ( empty($id) ) {
			$type = $this->get_field_type();
			$default_value = uniqid( sprintf('%s_', $type ) );
			$field->set_default_value( $default_value );
		}

		return $field;
	}

	public function get_field_active() {
		return Field::make( 'checkbox', static::FIELD_ACTIVE, __( 'Is Field Active and Should it be Added to each Archive Item?', 'ncpr-diviner' ) )
			->set_option_value( static::FIELD_CHECKBOX_VALUE )
			->set_default_value( static::FIELD_CHECKBOX_VALUE );
	}

	public function get_field_browser_helper_text() {
		return Field::make( 'text', static::FIELD_BROWSE_HELPER_TEXT, __( 'Browse Page Filter Helper Text', 'ncpr-diviner' ) )
			->set_help_text( __( 'Appears next to your field’s title on the Browse Page. If your field is Type of Work, your helper text may read: Example: Agriculture, Mining, Service, etc.', 'ncpr-diviner' ) );
	}

	public function get_field_admin_helper_text() {
		return Field::make( 'text', static::FIELD_ADMIN_HELPER_TEXT, __( 'Admin Experience Helper Text', 'ncpr-diviner' ) )
			->set_help_text( __( 'Select Field Variables', 'ncpr-diviner' ) );
	}

	public function get_field_browser_placement() {
		return Field::make( 'select', static::FIELD_BROWSE_PLACEMENT, __( 'Browse Page Placement', 'ncpr-diviner' ) )
			->add_options( static::PLACEMENT_OPTIONS )
			->set_help_text( __( 'Where this field will appear on your browse page. You can choose Top, Left, or none, if you do not wish to be able to search by this field (ex. if it is a call number relevant only to staff)', 'ncpr-diviner' ) );
	}

	public function get_field_display_popup() {
		return Field::make( 'checkbox', static::FIELD_BROWSE_DISPLAY, __( 'Check this if you want this field to appear in the popup overlay that appears after clicking an archive item in the Browse Page.', 'ncpr-diviner' ) )
			->set_option_value( static::FIELD_CHECKBOX_VALUE );
	}

	public function get_field_is_sortable() {
		return Field::make( 'checkbox', static::FIELD_BROWSE_IS_SORTABLE, __( 'Is this field sortable in the browse experience', 'ncpr-diviner' ) )
			->set_option_value( static::FIELD_CHECKBOX_VALUE )
			->set_classes( static::FIELD_BROWSE_IS_SORTABLE );
	}

	public function get_field_is_elastic() {
		return Field::make( 'checkbox', static::FIELD_BROWSE_IS_ELASTIC, __( 'Is this field searchable via the elastic search (only functional in tandem with elastic press plugin)', 'ncpr-diviner' ) )
			->set_option_value( static::FIELD_CHECKBOX_VALUE )
			->set_classes( static::FIELD_BROWSE_IS_ELASTIC );
	}

}
