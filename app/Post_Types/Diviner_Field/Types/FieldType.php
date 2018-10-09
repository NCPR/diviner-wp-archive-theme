<?php

namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\PostMeta;

abstract class FieldType implements iField {

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

	/**
	 * No operation method for setting up field. Extend if necessary
	 *
	 * @param  int $post_id Post Id of field to set up.
	 */
	static public function setup( $post_id ) {

	}

	/**
	 * Return basic blueprint for this field
	 *
	 * @param  int $post_id Post Id of field to set up.
	 */
	static public function get_blueprint( $post_id ) {
		return [
			'id'        => $post_id,
			'title'     => get_the_title( $post_id ),
			'position'  => carbon_get_post_meta( $post_id, PostMeta::FIELD_BROWSE_PLACEMENT, 'carbon_fields_container_field_variables' ),
			'helper'    => carbon_get_post_meta( $post_id, PostMeta::FIELD_BROWSE_HELPER_TEXT, 'carbon_fields_container_field_variables' ),
			'field_id'  => carbon_get_post_meta( $post_id, PostMeta::FIELD_ID, 'carbon_fields_container_field_variables' ),
		];
	}
}