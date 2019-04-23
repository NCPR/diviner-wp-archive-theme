<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

/**
 * Interface iField
 *
 * @package Diviner\Post_Types\Diviner_Field\Types
 */
interface iField {

	static public function render( $post_id, $id, $field_label, $helper = '');

	static public function setup( $post_id );

	static public function get_blueprint( $post_id );

	static public function hydrate_post_meta_cache( $field_id, $post_meta_items );

}
