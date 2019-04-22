<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;

/**
 * Class Taxonomy Field
 *
 * @package Diviner\Post_Types\Diviner_Field\Types
 */
class Taxonomy_Field extends FieldType {

	const NAME = 'diviner_taxonomy_field';
	const TITLE = 'Taxonomy Field';
	const TYPE = 'taxonomy';

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
		return '';
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
		$taxonomy_name = static::get_taxonomy_name( $field_post_id );
		// ToDo: link back to the browse screen
		return get_the_term_list( $post_id, $taxonomy_name, '', ', ' );
	}

	/**
	 * Set up the field
	 *
	 * @param  int $field_post_id Post Id of field.
	 */
	static public function setup( $field_post_id ) {
		$field_label_singular = Diviner_Field::get_field_post_meta( $field_post_id, FieldPostMeta::FIELD_TAXONOMY_SINGULAR_LABEL);
		$field_label_plural = Diviner_Field::get_field_post_meta( $field_post_id, FieldPostMeta::FIELD_TAXONOMY_PLURAL_LABEL);
		$field_slug = Diviner_Field::get_field_post_meta( $field_post_id, FieldPostMeta::FIELD_TAXONOMY_SLUG);
		$field_tax_type = Diviner_Field::get_field_post_meta( $field_post_id, FieldPostMeta::FIELD_TAXONOMY_TYPE);

		if ( empty( $field_slug ) ) {
			$field_slug = sanitize_title($field_label_singular);
		}

		if ( empty( $field_label_singular ) ) {
			$field_label_singular = sprintf(
				'Taxonomy %d',
				$field_post_id
			);
		}

		if ( empty( $field_label_plural ) ) {
			$field_label_plural = sprintf(
				__( 'Taxonomies %d', 'ncpr-diviner' ),
				$field_post_id
			);
		}

		// Labels
		$labels = [
			'name'              => $field_label_plural,
			'singular_name'     => $field_label_singular,
			'search_items'      => sprintf( __( 'Search %s', 'ncpr-diviner' ), $field_label_plural ),
			'all_items'         => sprintf( __( 'All %s', 'ncpr-diviner' ), $field_label_plural ),
			'parent_item'       => sprintf( __( 'Parent %s', 'ncpr-diviner' ), $field_label_singular ),
			'parent_item_colon' => sprintf( __( 'Parent %s:', 'ncpr-diviner' ), $field_label_singular ),
			'edit_item'         => sprintf( __( 'Edit %s', 'ncpr-diviner' ), $field_label_singular ),
			'update_item'       => sprintf( __( 'Update %s', 'ncpr-diviner' ), $field_label_singular ),
			'add_new_item'      => sprintf( __( 'Add %s', 'ncpr-diviner' ), $field_label_singular ),
			'new_item_name'     => sprintf( __( 'New %s', 'ncpr-diviner' ), $field_label_singular ),
			'menu_name'         => $field_label_singular,
		];

		$taxonomy_name = static::get_taxonomy_name( $field_post_id );

		// args
		$args = [
			'hierarchical'      => ( $field_tax_type === FieldPostMeta::FIELD_TAXONOMY_TYPE_CATEGORY ) ? true : false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [
				'slug' => $field_slug
			],
			'show_in_rest'      => true,
			'rest_base'         => $taxonomy_name,
		];
		register_taxonomy( $taxonomy_name, [ Archive_Item::NAME ], $args );

	}

	static public function get_taxonomy_name( $post_id ) {
		return sprintf(
			'%s_%s',
			static::NAME,
			$post_id
		);
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
			'taxonomy_field_type'  => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_TYPE),
			'taxonomy_field_slug'  => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SLUG),
			'taxonomy_field_singular_label'  => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SINGULAR_LABEL),
			'taxonomy_field_plural_label'  => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_PLURAL_LABEL),
			'taxonomy_field_name'   => static::get_taxonomy_name( $post_id ),
		];
		return array_merge($blueprint, $additional_vars);
	}
}
