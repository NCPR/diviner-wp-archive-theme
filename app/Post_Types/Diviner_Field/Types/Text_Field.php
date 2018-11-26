<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\CarbonFields\Helper;
use Carbon_Fields\Field;

class Text_Field extends FieldType {

	const NAME  = 'diviner_text_field';
	const TITLE = 'Text Field';
	const TYPE  = 'text';

	static public function render( $post_id, $id, $field_label, $helper = '') {
		$field =  Field::make( static::TYPE, $id, $field_label );
		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}

	/**
	 * Decorate query vars for rest
	 *
	 * @param  array $args  Args to pass to WP query.
	 * @param  array $sort_args  array of sort gtom pipe SORT|<type>|<field>|ASC
	 */
	static public function decorate_query_args ( $args, $sort_args ) {
		$args[ 'order' ] = ( $sort_args[3] == 'ASC' ) ? 'ASC' : 'DESC';
		$args[ 'meta_key' ] = Helper::get_real_field_name( $sort_args[2] );
		$args[ 'orderby' ] = 'meta_value';
		return $args;
	}

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
