<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Carbon_Fields\Field;

class Date_Field extends FieldType  {

	const NAME = 'diviner_date_field';
	const TITLE = 'Date Field';
	const TYPE = 'date';

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}


}
