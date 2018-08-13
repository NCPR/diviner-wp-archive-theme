<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

abstract class FieldType implements iField {

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

	/**
	 * No operation method for setting up field. Extend if necessary
	 *
	 * @param  int $post_id Post Id of field to set up.
	 */
	static public function setup( $post_id ) {

	}
}