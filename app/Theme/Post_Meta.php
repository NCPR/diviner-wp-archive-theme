<?php

namespace Diviner\Theme;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Class Post_Meta
 *
 * Generic Post Meta for Theme
 *
 * @package Diviner\Theme
 */
class Post_Meta {

	const FIELD_SUBHEADER_TEXT = 'div_field_subheader_text';

	protected $container;

	/**
	 * Hooks for class
	 */
	public function hooks() {
		add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 3, 0 );
	}

	/**
	 * Adds post meta
	 */
	public function add_post_meta() {
		// ToDo revisit once the ->set_context( 'side' ) works better
		$container = Container::make( 'post_meta', __( 'Subheader', 'ncpr-diviner' ) )
			->where( 'post_type', '=', 'page' )
			->or_where( 'post_type', '=', 'post' )
			->add_fields( [
				$this->get_field_subheader_text(),
			] )
			->set_priority( 'high' );
	}

	/**
	 * Returns subheader text field
	 */
	public function get_field_subheader_text()
	{
		return Field::make(
			'text',
			static::FIELD_SUBHEADER_TEXT,
			__( 'Subheader Text', 'ncpr-diviner' )
		);

	}

}
