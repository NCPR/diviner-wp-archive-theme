<?php


namespace Diviner\Post_Types\Diviner_Field;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

use Diviner\CarbonFields\Helper;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;


class PostMeta {

	const CONTAINER_FIELDS = 'div_container_fields';

	const FIELD_ACTIVE = 'div_field_active';
	const FIELD_CHECKBOX_VALUE = '1';
	const FIELD_TYPE = 'div_field_type';

	const FIELD_ID = 'div_field_id';

	const FIELD_BROWSE_HELPER_TEXT = 'div_field_browse_helper';
	const FIELD_ADMIN_HELPER_TEXT = 'div_field_admin_helper';
	const FIELD_BROWSE_PLACEMENT = 'div_field_browse_placement';
	const FIELD_BROWSE_DISPLAY = 'div_field_display';

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

	public function add_post_meta() {
		global $typenow;
		global $current_screen;

		// var_dump('PostMeta add_post_meta');
		$this->container = Container::make( 'post_meta', __( 'Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_types(),
				$this->get_field_active(),
				$this->get_field_browser_helper_text(),
				$this->get_field_browser_placement(),
				$this->get_field_display_popup(),
				$this->get_field_admin_helper_text(),
                $this->get_field_id(),
			))
			->set_priority( 'high' );

		// if on edit screen check the field type
		$is_admin_on_edit_page = $this->is_edit_page();
		$field_type = NULL;
		if ($is_admin_on_edit_page) {
			$field_type = $this->get_field_type($_GET['post']);
		}

		$this->container = Container::make( 'post_meta', __( 'Hidden Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_is_custom(),
			))
			->set_priority( 'low' );

		$date_required = ( $field_type === Date_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Date Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_date_type($date_required),
				$this->get_field_date_start($date_required),
				$this->get_field_date_end($date_required),
			))
			->set_priority( 'low' );

		$taxonomy_required = ( $field_type === Taxonomy_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Taxonomy Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_taxonomy_type($taxonomy_required),
				$this->get_field_taxonomy_singular_label($taxonomy_required),
				$this->get_field_taxonomy_plural_label($taxonomy_required),
				$this->get_field_taxonomy_slug($taxonomy_required),
			))
			->set_priority( 'low' );

		$cpt_required = ( $field_type === CPT_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Custom Post Type Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_cpt_id($cpt_required),
				$this->get_field_cpt_label($cpt_required),
				$this->get_field_cpt_slug($cpt_required),
			))
			->set_priority( 'low' );

		$select_required = ( $field_type === Select_Field::NAME );
		$this->container = Container::make( 'post_meta', __( 'Select Field Variables', 'ncpr-diviner' ) )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_select_options($select_required),
			))
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
				return carbon_get_post_meta( $post_id,self::FIELD_TYPE);
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

		if($new_edit == "edit")
			return in_array( $pagenow, array( 'post.php',  ) );
		elseif($new_edit == "new") //check for new post page
			return in_array( $pagenow, array( 'post-new.php' ) );
		else //check for either new or edit
			return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
	}

	public function get_field_select_options($required = false) {
		return Field::make( 'complex', self::FIELD_SELECT_OPTIONS, __( 'Select Options', 'ncpr-diviner' ) )
			->add_fields( $this->get_field_select_option_fields($required) );
	}

	public function get_field_select_option_fields($required = false) {
		$args = [];
		$args[] = Field::make( 'text', self::FIELD_SELECT_OPTIONS_VALUE, __( 'Value', 'ncpr-diviner' ) )
			->set_help_text( __( 'Use only lower case and underscores. No spaces. Used in the URL for facets search', 'ncpr-diviner' ) )
			->set_required( $required );
		$args[] = Field::make( 'text', self::FIELD_SELECT_OPTIONS_LABEL, __( 'Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'Appears in the dropdown', 'ncpr-diviner' ) )
			->set_required( $required );
		return $args;
	}

	public function get_field_cpt_id($required = false) {
		return Field::make( 'text', self::FIELD_CPT_ID, __( 'Custom Post Type ID (use only lower case with underscores)', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_cpt_label($required = false) {
		return Field::make( 'text', self::FIELD_CPT_LABEL, __( 'Custom Post Label', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_cpt_slug($required = false) {
		return Field::make( 'text', self::FIELD_CPT_SLUG, __( 'Custom Post Slug (use only lower case with dashes)', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_slug($required = false) {
		return Field::make( 'text', self::FIELD_TAXONOMY_SLUG, __( 'Taxonomy Slug', 'ncpr-diviner' ) )
			->set_help_text( __( 'No spaces or underscores', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_singular_label($required = false) {
		return Field::make( 'text', self::FIELD_TAXONOMY_SINGULAR_LABEL, __( 'Singular Taxonomy Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'ex: Type of Work', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_plural_label($required = false) {
		return Field::make( 'text', self::FIELD_TAXONOMY_PLURAL_LABEL, __( 'Plural Taxonomy Label', 'ncpr-diviner' ) )
			->set_help_text( __( 'ex: Types of Work', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_taxonomy_type($required = false) {
		return Field::make( 'select', self::FIELD_TAXONOMY_TYPE, __( 'Type of taxonomy field', 'ncpr-diviner' ) )
			->add_options(self::FIELD_TAXONOMY_TYPE_OPTIONS)
			->set_help_text( __( 'Tag or category', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_start($required = false) {
		return Field::make( 'date', self::FIELD_DATE_START, __( 'Start Date of Slider', 'ncpr-diviner' ) )
			->set_help_text( __( 'If type is century, start date rounds down to nearest century. If type if decade, start date rounds to nearest decade. Only uses year.', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_end($required = false) {
		return Field::make( 'date', self::FIELD_DATE_END, __( 'End Date of Slider', 'ncpr-diviner' ) )
			->set_help_text( __( 'If type is century, end date rounds down to nearest century. If type if decade, end date rounds to nearest decade. Only uses year.', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_date_type($required = false) {
		return Field::make( 'select', self::FIELD_DATE_TYPE, __( 'Type of date field', 'ncpr-diviner' ) )
			->add_options(self::FIELD_DATE_TYPE_OPTIONS)
			->set_help_text( __( 'Century slider, Decade slider, Year slider, and two date min max selector', 'ncpr-diviner' ) )
			->set_required( $required );
	}

	public function get_field_is_custom($required = false) {
		return Field::make( 'checkbox', self::FIELD_IS_DEFAULT, __( 'Is Default Field', 'ncpr-diviner' ) )
			->set_option_value( self::FIELD_CHECKBOX_VALUE )
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
		$field =  Field::make( 'select', self::FIELD_TYPE, __( 'Type of field', 'ncpr-diviner' ) )
			->set_classes( self::FIELD_TYPE )
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
		$type = carbon_get_post_meta( $id, PostMeta::FIELD_TYPE );
		if ( ! empty($type) ) {
			return $type;
		}
		if ( !empty( $_GET[ 'field_type' ] ) ) {
			return $_GET[ 'field_type' ];
		}
		return null;
	}

	public function get_field_id() {
		$field = Field::make( 'text', self::FIELD_ID, __( 'Field ID (for reference only)', 'ncpr-diviner' ) )
			->set_required( true )->set_classes( self::FIELD_ID );

		$id = carbon_get_post_meta( get_the_ID(), PostMeta::FIELD_ID );

		if ( empty($id) ) {
			$type = $this->get_field_type();
			$default_value = uniqid( sprintf('%s_', $type ) );
			$field->set_default_value( $default_value );
		}

		// ->set_default_value( $default_value );

		return $field;
	}

	public function get_field_active() {
		return Field::make( 'checkbox', self::FIELD_ACTIVE, __( 'Is Field Active and Should it be Added to each Archive Item?', 'ncpr-diviner' ) )
			->set_option_value( self::FIELD_CHECKBOX_VALUE );
	}

	public function get_field_browser_helper_text() {
		return Field::make( 'text', self::FIELD_BROWSE_HELPER_TEXT, __( 'Browse Page Filter Helper Text', 'ncpr-diviner' ) );
	}

	public function get_field_admin_helper_text() {
		return Field::make( 'text', self::FIELD_ADMIN_HELPER_TEXT, __( 'Admin Experience Helper Text', 'ncpr-diviner' ) )
			->set_help_text( __( 'Select Field Variables', 'ncpr-diviner' ) );
	}

	public function get_field_browser_placement() {
		return Field::make( 'select', self::FIELD_BROWSE_PLACEMENT, __( 'Browse Page Placement', 'ncpr-diviner' ) )
			->add_options(self::PLACEMENT_OPTIONS)
			->set_help_text( __( 'Where this field appears in the browse page (top left or none)', 'ncpr-diviner' ) );
	}

	public function get_field_display_popup() {
		return Field::make( 'checkbox', self::FIELD_BROWSE_DISPLAY, __( 'Ensure the Field Appears in Popup Overlay After a User Clicks a Thumbnail in the Search Returns Grid', 'ncpr-diviner' ) )
			->set_option_value( self::FIELD_CHECKBOX_VALUE );
	}

}
