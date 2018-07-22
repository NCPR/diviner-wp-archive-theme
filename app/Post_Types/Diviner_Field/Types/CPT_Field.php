<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Carbon_Fields\Field;

class CPT_Field extends FieldType {

	const NAME = 'diviner_cpt_field';
	const TITLE = 'CPT Field';

	static public function hook () {
		// registering the custom post type
	}

	static public function render( $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}


}
