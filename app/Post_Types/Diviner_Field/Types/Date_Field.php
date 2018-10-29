<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Carbon_Fields\Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;

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

	static public function get_blueprint( $post_id ) {
		$blueprint = parent::get_blueprint( $post_id );
		$additional_vars = [
			'date_field_type'  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_DATE_TYPE),
			'date_field_start' => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_DATE_START),
			'date_field_end'   => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_DATE_END),
		];
		return array_merge($blueprint, $additional_vars);
	}

}
