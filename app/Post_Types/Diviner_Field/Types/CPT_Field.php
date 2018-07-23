<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Carbon_Fields\Field;
use Carbon_Fields\Container;

use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;

class CPT_Field extends FieldType {

	const NAME = 'diviner_cpt_field';
	const TITLE = 'CPT Field';
	const TYPE = 'association';

	const FIELD_CPT_TYPE_FIELD_ID = 'diviner_cpt_type_field';

	static public function setup () {
		// set up CPT
		$field_id = carbon_get_the_post_meta( FieldPostMeta::FIELD_CPT_ID );
		$field_label = carbon_get_the_post_meta( FieldPostMeta::FIELD_CPT_LABEL );
		$field_slug = carbon_get_the_post_meta( FieldPostMeta::FIELD_CPT_SLUG );

		if ( empty( $field_id ) ) {
			$field_id = 'diviner_cpt_id';
		}

		if ( empty( $field_label ) ) {
			$field_label = 'Diviner CPT';
		}
		$field_labels = sprintf('%ss', $field_label);

		if ( empty( $field_slug ) ) {
			$field_slug = 'diviner-cpt';
		}

		// registering the custom post type
		$args = [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $field_slug ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			'map_meta_cap'       => true,
			// 'has_archive'     => _x( 'archive-item', 'post archive slug', 'tribe' ),
		];
		$labels = [
			'labels' => [
				'singular'     => $field_label,
				'plural'       => $field_labels,
				'name'         => $field_labels,
				'add_new_item' => sprintf( 'Add New %s', $field_label ),
			]
		];
		$args = wp_parse_args( $args, $labels );
		register_post_type( $field_id, $args );

		// set up additional field?? Unnecessary for now
		/*
		$container = Container::make( 'post_meta', 'Creator Fields' )
			->where( 'post_type', '=', Diviner_Field::NAME )
			->add_fields( array(
				Field::make( 'text', self::FIELD_CPT_TYPE_FIELD_ID, 'CPT Type Field ID' )
			))
			->set_priority( 'default' );
		*/

	}

	static public function render( $id, $field_label, $helper = '') {
		// $field =  Field::make( static::TYPE, $id, $field_label );

		$field_cpt_id = carbon_get_the_post_meta( FieldPostMeta::FIELD_CPT_ID );
		if ( empty($field_cpt_id) ) {
			return null;
		}

		$field = Field::make(static::TYPE, $id, $field_label)
			->set_types(array(
				array(
					'type' => 'post',
					'post_type' => $field_cpt_id,
				),
			));

		if ( ! empty( $helper ) ) {
			$field->help_text($helper);
		}
		return $field;
	}
}
