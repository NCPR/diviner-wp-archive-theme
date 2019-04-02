<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\PostMeta;
use Carbon_Fields\Field;

/**
 * Abstract Field Type
 *
 * @package Diviner\Post_Types\Diviner_Field\Types
 */
abstract class FieldType implements iField {

	const TYPE = 'date';

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
	 * @param  int $post_id Post Id of field to set up.
	 * @return array
	 */
	static public function decorate_ep_post_sync_args( $additional_meta, $post_id, $field, $field_id ) {
		return $additional_meta;
	}

	/**
	 * No operation method for setting up field. Extend if necessary
	 *
	 * @param  int $post_id Post Id of field to set up.
	 */
	static public function setup( $post_id ) {
	}

	/**
	 * Decorate query vars for rest
	 *
	 * @param  array $args  Args to pass to WP query.
	 * @param  array $sort_args  array of sort gtom pipe SORT|<type>|<field>|ASC
	 * @return array
	 */
	static public function decorate_query_args ( $args, $sort_args ) {
		return $args;
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
		return carbon_get_post_meta( $post_id, $field_name );
	}

	/**
	 * Return array of sort options
	 *
	 * @param  int $post_id Post Id of field to set up.
	 * @return array
	 */
	static public function get_sort_options( $post_id ) {
		return [];
	}

	/**
	 * Return basic blueprint for this field
	 *
	 * @param  int $post_id Post Id of field to set up.
	 * @return array
	 */
	static public function get_blueprint( $post_id ) {
		return [
			'id'                => $post_id,
			'title'             => get_the_title( $post_id ),
			'position'          => carbon_get_post_meta( $post_id, PostMeta::FIELD_BROWSE_PLACEMENT, 'carbon_fields_container_field_variables' ),
			'helper'            => carbon_get_post_meta( $post_id, PostMeta::FIELD_BROWSE_HELPER_TEXT, 'carbon_fields_container_field_variables' ),
			'field_id'          => carbon_get_post_meta( $post_id, PostMeta::FIELD_ID, 'carbon_fields_container_field_variables' ),
			'display_in_popup'  => carbon_get_post_meta( $post_id, PostMeta::FIELD_BROWSE_DISPLAY, 'carbon_fields_container_field_variables' ),
		];
	}
}