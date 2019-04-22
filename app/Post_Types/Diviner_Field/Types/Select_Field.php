<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Carbon_Fields\Field;

/**
 * Class Select Field
 *
 * @package Diviner\Post_Types\Diviner_Field\Types
 */
class Select_Field extends FieldType {

	const NAME = 'diviner_select_field';
	const TITLE = 'Select Field';
	const TYPE = 'select';
	const REST_SELECT_OPTIONS = 'select_field_options';

	/**
	 * Builds the field and returns it
	 *
	 * @param  int $post_id Post Id of field to set up.
	 * @param  string $id Field id
	 * @param  string $field_label Label
	 * @param  string $helper field helper text
	 * @return object
	 */
	static public function render( $post_id, $id, $field_label, $helper = '') {
		$options = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_SELECT_OPTIONS );
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

	/**
	 * Return field value
	 *
	 * @param  int $post_id Post Id of archive item.
	 * @param  string $field_name ID of field to get value of
	 * @param  int $field_post_id Field Id
	 * @return string
	 */
	static public function get_value( $post_id, $field_name, $field_post_id ) {
		$raw_value = carbon_get_post_meta( $post_id, $field_name );
		$options = Diviner_Field::get_field_post_meta( $field_post_id, FieldPostMeta::FIELD_SELECT_OPTIONS);

		$filtered_options = array_filter(
			$options,
			function ($val, $key) use ($raw_value) {
				return $val[FieldPostMeta::FIELD_SELECT_OPTIONS_VALUE] === $raw_value;
			},
			ARRAY_FILTER_USE_BOTH
		);
		$flattened_options = array_values($filtered_options);
		if (isset($flattened_options[0])) {
			return $flattened_options[0][FieldPostMeta::FIELD_SELECT_OPTIONS_LABEL];
		}
		return $raw_value;
	}

	/**
	 * Decorate the ep sync args per field type
	 *
	 * @param  array $additional_meta additional meta.
	 * @param  int $post_id Post Id of field to set up.
	 * @param  array $field
	 * @param  array $field_id
	 * @return array
	 */
	static public function decorate_ep_post_sync_args( $additional_meta, $post_id, $field, $field_id ) {
		$field_value = carbon_get_post_meta( $post_id, $field_id );
		$additional_meta[$field_id] = $field_value;
		return $additional_meta;
	}

	/**
	 * Return basic blueprint for this field
	 *
	 * @param  int $post_id Post Id of field to set up.
	 * @return array
	 */
	static public function get_blueprint( $post_id ) {
		$blueprint = parent::get_blueprint( $post_id );
		$additional_vars = [
			static::REST_SELECT_OPTIONS  => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_SELECT_OPTIONS),
		];
		return array_merge($blueprint, $additional_vars);
	}

}
