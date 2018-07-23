<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Carbon_Fields\Field;

class Select_Field extends FieldType {

	const NAME = 'diviner_select_field';
	const TITLE = 'Select Field';
	const TYPE = 'select';

	static public function render( $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

}
