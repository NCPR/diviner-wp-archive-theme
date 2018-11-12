<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Carbon_Fields\Field;

class Select_Field extends FieldType {

	const NAME = 'diviner_select_field';
	const TITLE = 'Select Field';
	const TYPE = 'select';
	const REST_SELECT_OPTIONS = 'select_field_options';

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$options = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_SELECT_OPTIONS);
		if (count($options) <= 1) {
			return '';
		}
		$field =  Field::make( static::TYPE, $id, $field_label );
		// add none value to all selects
		$filtered_options = [
			'none' => ''
		];
		foreach ($options as $option) {
			$filtered_options[$option[FieldPostMeta::FIELD_SELECT_OPTIONS_VALUE]] = $option[FieldPostMeta::FIELD_SELECT_OPTIONS_LABEL];
		}
		$field->add_options( $filtered_options );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

	static public function get_blueprint( $post_id ) {
		$blueprint = parent::get_blueprint( $post_id );
		$additional_vars = [
			self::REST_SELECT_OPTIONS  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_SELECT_OPTIONS),
		];
		return array_merge($blueprint, $additional_vars);
	}

}
