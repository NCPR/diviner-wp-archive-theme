<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

use Carbon_Fields\Field;

class FieldType {

	const TYPE = 'text'; // default

	static public function render( $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

}