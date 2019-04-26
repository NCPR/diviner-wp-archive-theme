<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

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
		$options = Select_Field::get_select_options( $post_id ); // retrieve from cache
		if (count($options) <= 1) {
			return null;
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
	 * Get select options
	 *
	 * @param  $field_id string
	 * @return object
	 */
	static public function get_select_options( $field_id ) {
		$key = sprintf(
			'%s%s',
			$field_id,
			FieldPostMeta::FIELD_SELECT_OPTIONS
		);
		return wp_cache_get( $key );
	}

	/**
	 * Hydrate post meta. Pulls out the selections options and builds an array of object loking like this
	 *
	 * array (size=3)
	 *  '_type' => string '_' (length=1)
	 *  'div_field_select_options_value' => string 'blond' (length=5)
	 *  'div_field_select_options_label' => string 'Blond' (length=5)
	 *
	 * The FIELD_SELECT_OPTIONS complex field is either empty with a value like this
	 *
	 * _div_field_select_options|||0|_empty
	 *
	 * or its a series of entries in the following format
	 *
	 * array (size=3)
	 *   0 => object(stdClass)[673]
	 *    public 'key' => string '_div_field_select_options|||0|value' (length=35)
	 *    public 'value' => string '_' (length=1)
	 *   1 => object(stdClass)[672]
	 *    public 'key' => string '_div_field_select_options|div_field_select_options_label|0|0|value' (length=66)
	 *    public 'value' => string 'Bordeaux' (length=8)
	 *   2 => object(stdClass)[671]
	 *    public 'key' => string '_div_field_select_options|div_field_select_options_value|0|0|value' (length=66)
	 *    public 'value' => string 'bordeaux' (length=8)
	 *
	 * @param  $field_id string
	 * @param  $post_meta_items array
	 * @return void
	 */
	static public function hydrate_post_meta_cache( $field_id, $post_meta_items ) {
		$select_options = [];
		$other_post_meta = [];
		$needle = FieldPostMeta::FIELD_SELECT_OPTIONS;
		array_walk($post_meta_items, function ($item) use (&$select_options, &$other_post_meta, $needle)  {
			if ( preg_match("/{$needle}/i", $item->key) ) {
				$select_options[] = $item;
			} else {
				$other_post_meta[] = $item;
			}
		});

		// create select options array
		$select_options_array = [];
		// if the complex selection options field is empty there is one entry with a value of _div_field_select_options|||0|_empty
		if ( is_array( $select_options ) && count( $select_options ) > 1 ) {
			usort($select_options, function($obj1, $obj2) {
				return strcasecmp($obj1->key, $obj2->key) < 0;
			});
			$num_items = (int)ceil(count($select_options) / 3 );
			for ($i = 0; $i < $num_items; $i++) {
				if (!is_object($select_options[$i])) {
					continue;
				}
				$type = ( isset( $select_options[$i] ) && is_object( $select_options[$i] ) && isset( $select_options[$i]->value ) ) ? $select_options[$i]->value : '' ;
				$value = ( isset( $select_options[$num_items + $i] ) && is_object( $select_options[$num_items + $i] ) && isset( $select_options[$num_items + $i]->value ) ) ? $select_options[$num_items + $i]->value : '' ;
				$label = ( isset( $select_options[(2 * $num_items) + $i] ) && is_object( $select_options[(2 * $num_items) + $i] ) && isset( $select_options[(2 * $num_items) + $i]->value ) ) ? $select_options[(2 * $num_items) + $i]->value : '' ;

				$select_options_array[] = [
					'_type' => $type,
					FieldPostMeta::FIELD_SELECT_OPTIONS_VALUE => $value,
					FieldPostMeta::FIELD_SELECT_OPTIONS_LABEL => $label,
				];
			}
		}
		$key = sprintf(
			'%s%s',
			$field_id,
			FieldPostMeta::FIELD_SELECT_OPTIONS
		);
		wp_cache_set( $key, $select_options_array );

		parent::hydrate_post_meta_cache( $field_id, $other_post_meta );
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
		$options = Select_Field::get_select_options( $post_id ); // retrieve from cache
		if ( !is_array($options) ) {
			return '';
		}
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
	 * @param  int|string $field_id
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
		$options = Select_Field::get_select_options( $post_id ); // retrieve from cache
		$additional_vars = [
			static::REST_SELECT_OPTIONS  => $options,
		];
		return array_merge($blueprint, $additional_vars);
	}

}
