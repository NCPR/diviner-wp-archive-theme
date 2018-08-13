<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Carbon_Fields\Field;

class Select_Field extends FieldType {

	const NAME = 'diviner_select_field';
	const TITLE = 'Select Field';
	const TYPE = 'select';

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$options = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_SELECT_OPTIONS);
		if (count($options) <= 1) {
			return '';
		}
		$field =  Field::make( static::TYPE, $id, $field_label );
		$filtered_options = array_column($options, 'div_field_select_options_label');
		$field->add_options( $filtered_options );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

}
