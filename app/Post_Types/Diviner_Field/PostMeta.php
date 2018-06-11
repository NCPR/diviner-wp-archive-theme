<?php


namespace Diviner\Post_Types\Diviner_Field;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class PostMeta {

	const FIELD_LABEL_TITLE = 'div_field_label_title';
	const FIELD_BROWSE_HELPER_TEXT = 'div_field_browse_helper';
	const FIELD_ADMIN_HELPER_TEXT = 'div_field_admin_helper';
	const FIELD_BROWSE_PLACEMENT = 'div_field_browse_placement';
	const FIELD_BROWSE_INCLUDE_SEARCH = 'div_field_include_search';
	const FIELD_BROWSE_DISPLAY = 'div_field_display';

	const FIELD_IS_DEFAULT     = 'div_field_default';

	const FIELD_TAXONOMY_TYPE = 'div_field_taxonomy_type';
	const FIELD_TAXONOMY_TYPE_TAG = 'div_field_taxonomy_type_tag';
	const FIELD_TAXONOMY_TYPE_CATEGORY= 'div_field_taxonomy_type_category';
	const FIELD_TAXONOMY_TYPE_OPTIONS = [
		self::FIELD_TAXONOMY_TYPE_TAG  => 'Tag',
		self::FIELD_TAXONOMY_TYPE_CATEGORY   => 'Category'
	];

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
	const PLACEMENT_OPTIONS_LEFT = 'top';
	const PLACEMENT_OPTIONS = [
		self::PLACEMENT_OPTIONS_NONE  => 'None',
		self::PLACEMENT_OPTIONS_TOP   => 'Top',
		self::PLACEMENT_OPTIONS_LEFT  => 'Left'
	];

	protected $container;

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		register_post_type( self::NAME, $args );
	}

	public function add_post_meta() {
		$this->container = Container::make( 'post_meta', 'Field Variables' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				$this->get_field_label_field(),
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
			))
			->set_priority( 'low' );
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
			->set_option_value( true )
			->set_required( true )
			->set_required( false );
	}

	public function get_field_label_field() {
		return Field::make( 'text', self::FIELD_LABEL_TITLE, 'Field Label' );
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
			->set_option_value( 'yes' );
	}

	public function get_field_display() {
		return Field::make( 'checkbox', self::FIELD_BROWSE_DISPLAY, 'Appear in Modal Overlay' )
			->set_option_value( 'yes' );
	}

}
