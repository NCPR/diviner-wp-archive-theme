<?php

namespace Diviner\Theme;


/**
 * Class Post_Meta
 *
 * Generic Post Meta for Theme (Gutenberg?)
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
		// add_action( 'carbon_fields_register_fields', [ $this, 'add_post_meta' ], 3, 0 );
	}

}
