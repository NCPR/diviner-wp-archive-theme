<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
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
	 * Hydrate post meta
	 *
	 * @param  $field_id string
	 * @param  $post_meta_items array
	 * @return void
	 */
	static public function hydrate_post_meta_cache( $field_id, $post_meta_items ) {
		$needle = '_div_field_';
		// filter by div related
		$filtered_post_meta = array_filter($post_meta_items, function ($item) use ($needle)  {
			return ( substr( $item->key, 0, 11 ) === $needle ) ;
		});
		foreach ($filtered_post_meta as &$post_meta_item) {
			$key = sprintf(
				'%s%s',
				$field_id,
				$post_meta_item->key
			);
			wp_cache_set( $key, $post_meta_item->value );
		}
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
			'position'          => Diviner_Field::get_field_post_meta( $post_id, PostMeta::FIELD_BROWSE_PLACEMENT ),
			'helper'            => Diviner_Field::get_field_post_meta( $post_id, PostMeta::FIELD_BROWSE_HELPER_TEXT ),
			'field_id'          => Diviner_Field::get_field_post_meta( $post_id, PostMeta::FIELD_ID ),
			'display_in_popup'  => (bool) Diviner_Field::get_field_post_meta( $post_id, PostMeta::FIELD_BROWSE_DISPLAY ),
		];
	}
}