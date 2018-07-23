<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

abstract class FieldType implements iField {

	static public function render( $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

	static public function setup() {

	}
}