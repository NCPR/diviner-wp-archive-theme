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

class PostMeta {

	const CONTAINER_FIELDS = 'div_container_fields';

	const FIELD_ACTIVE = 'div_field_active';
	const FIELD_CHECKBOX_VALUE = '1';
	const FIELD_TYPE = 'div_field_type';

	const FIELD_ID = 'div_field_id';

	const FIELD_BROWSE_HELPER_TEXT = 'div_field_browse_helper';
	const FIELD_ADMIN_HELPER_TEXT = 'div_field_admin_helper';
	const FIELD_BROWSE_PLACEMENT = 'div_field_browse_placement';
	const FIELD_BROWSE_INCLUDE_SEARCH = 'div_field_include_search';
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
		// var_dump('PostMeta add_post_meta');
		$this->container = Container::make( 'post_meta', 'Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_types(),
				$this->get_field_id(),
				$this->get_field_active(),
				$this->get_field_browser_helper_text(),
				$this->get_field_browser_placement(),
				$this->get_field_include_search(),
				$this->get_field_display(),
				$this->get_field_admin_helper_text(),
			))
			->set_priority( 'high' );

		$this->container = Container::make( 'post_meta', 'Hidden Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_is_custom(),
			))
			->set_priority( 'low' );

		$this->container = Container::make( 'post_meta', 'Date Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_date_type(),
			))
			->set_priority( 'low' );

		$this->container = Container::make( 'post_meta', 'Taxonomy Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_taxonomy_type(),
				$this->get_field_taxonomy_singular_label(),
				$this->get_field_taxonomy_plural_label(),
				$this->get_field_taxonomy_slug(),
			))
			->set_priority( 'low' );

		$this->container = Container::make( 'post_meta', 'Custom Post Type Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_cpt_id(),
				$this->get_field_cpt_label(),
				$this->get_field_cpt_slug(),
			))
			->set_priority( 'low' );

		$this->container = Container::make( 'post_meta', 'Select Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_select_options(),
			))
			->set_priority( 'low' );
	}

	public function get_field_select_options() {
		return Field::make( 'complex', self::FIELD_SELECT_OPTIONS )
			->add_fields( array(
				Field::make( 'text', self::FIELD_SELECT_OPTIONS_LABEL, 'Drop down label' ),
			) );
	}

	public function get_field_cpt_id() {
		return Field::make( 'text', self::FIELD_CPT_ID, 'Custom Post Type ID (use only lower case with underscores)' );
	}

	public function get_field_cpt_label() {
		return Field::make( 'text', self::FIELD_CPT_LABEL, 'Custom Post Label' );
	}

	public function get_field_cpt_slug() {
		return Field::make( 'text', self::FIELD_CPT_SLUG, 'Custom Post Label (use only lower case with dashes)' );
	}

	public function get_field_taxonomy_slug() {
		return Field::make( 'text', self::FIELD_TAXONOMY_SLUG, 'Taxonomy Slug' )
			->set_help_text( 'no spaces or underscores' );
	}

	public function get_field_taxonomy_singular_label() {
		return Field::make( 'text', self::FIELD_TAXONOMY_SINGULAR_LABEL, 'Singular Taxonomy Label' )
			->set_help_text( 'ex: Type of Work' );
	}

	public function get_field_taxonomy_plural_label() {
		return Field::make( 'text', self::FIELD_TAXONOMY_PLURAL_LABEL, 'Plural Taxonomy Label' )
			->set_help_text( 'ex: Types of Work' );
	}

	public function get_field_taxonomy_type() {
		return Field::make( 'select', self::FIELD_TAXONOMY_TYPE, 'Type of taxonomy field' )
			->add_options(self::FIELD_TAXONOMY_TYPE_OPTIONS)
			->set_help_text( 'Tag or category' );
	}

	public function get_field_date_type() {
		return Field::make( 'select', self::FIELD_DATE_TYPE, 'Type of date field' )
			->add_options(self::FIELD_DATE_TYPE_OPTIONS)
			->set_help_text( 'Century slider, Decade slider, Year slider, and two date min max selector' );
	}

	public function get_field_is_custom() {
		return Field::make( 'checkbox', self::FIELD_IS_DEFAULT, 'Is Default Field' )
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
		$field =  Field::make( 'select', self::FIELD_TYPE, 'Type of field' )
			->set_classes( self::FIELD_TYPE )
			->add_options($types)
			->set_help_text( 'What kind of field is this' );

		if ( !empty( $_GET[ 'field_type' ] ) ) {
			$default_value = $_GET[ 'field_type' ];
			$field->set_default_value( $default_value );
		}
		return $field;
	}

	public function get_field_type() {
		$type = carbon_get_post_meta( get_the_ID(), PostMeta::FIELD_TYPE );
		if ( ! empty($type) ) {
			return $type;
		}
		if ( !empty( $_GET[ 'field_type' ] ) ) {
			return $_GET[ 'field_type' ];
		}
		return null;
	}

	public function get_field_id() {
		$field = Field::make( 'text', self::FIELD_ID, 'Field ID (for reference only)' )
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
		return Field::make( 'checkbox', self::FIELD_ACTIVE, 'Is Field Active?' )
			->set_option_value( self::FIELD_CHECKBOX_VALUE );
	}

	public function get_field_browser_helper_text() {
		return Field::make( 'text', self::FIELD_BROWSE_HELPER_TEXT, 'Browse Page Filter Helper Text' );
	}

	public function get_field_admin_helper_text() {
		return Field::make( 'text', self::FIELD_ADMIN_HELPER_TEXT, 'Admin Experience Helper Text' )
			->set_help_text( 'Appears in the admin page' );;
	}

	public function get_field_browser_placement() {
		return Field::make( 'select', self::FIELD_BROWSE_PLACEMENT, 'Placement in the Browse Page' )
			->add_options(self::PLACEMENT_OPTIONS)
			->set_help_text( 'Top left or none' );
	}

	public function get_field_include_search() {
		return Field::make( 'checkbox', self::FIELD_BROWSE_INCLUDE_SEARCH, 'Include in search' )
			->set_option_value( self::FIELD_CHECKBOX_VALUE );
	}

	public function get_field_display() {
		return Field::make( 'checkbox', self::FIELD_BROWSE_DISPLAY, 'Appear in Modal Overlay' )
			->set_option_value( self::FIELD_CHECKBOX_VALUE );
	}

}
