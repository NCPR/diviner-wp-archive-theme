<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Carbon_Fields\Field;

class Taxonomy_Field extends FieldType {

	const NAME = 'diviner_taxonomy_field';
	const TITLE = 'Taxonomy Field';
	const TYPE = 'taxonomy';

	static public function render( $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}


}
