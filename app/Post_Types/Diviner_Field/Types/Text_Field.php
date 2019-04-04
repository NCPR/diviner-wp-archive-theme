<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\CarbonFields\Helper;
use Carbon_Fields\Field;

/**
 * Class Text Field
 *
 * @package Diviner\Post_Types\Diviner_Field\Types
 */
class Text_Field extends FieldType {

	const NAME  = 'diviner_text_field';
	const TITLE = 'Text Field';
	const TYPE  = 'text';

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
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
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
	 * Decorate query vars for rest
	 *
	 * @param  array $args  Args to pass to WP query.
	 * @param  array $sort_args  array of sort gtom pipe SORT|<type>|<field>|ASC
	 * @return array
	 */
	static public function decorate_query_args ( $args, $sort_args ) {
		$args[ 'order' ] = ( $sort_args[3] == 'ASC' ) ? 'ASC' : 'DESC';
		$args[ 'meta_key' ] = Helper::get_real_field_name( $sort_args[2] );
		$args[ 'orderby' ] = 'meta_value';
		return $args;
	}

	/**
	 * Return array of sort options
	 *
	 * @param  int $post_id Post Id of field to set up.
	 * @return array
	 */
	static public function get_sort_options( $field_id ) {
		$options = [];
		// Ascending
		$label = sprintf(
			__( 'Alphabetical %s', 'ncpr-diviner' ),
			get_the_title($field_id)
		);
		$value = sprintf(
			'SORT|%s|%s|ASC',
			static::NAME,
			carbon_get_post_meta( $field_id, FieldPostMeta::FIELD_ID )
		);
		$options[] = [
			'value' => $value,
			'label' => $label,
		];
		return $options;
	}

}
