<?php


namespace Diviner\Post_Types\Diviner_Field\Types;

use Diviner\Post_Types\Diviner_Field\Types\FieldType;
use Carbon_Fields\Field;
use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;

class Taxonomy_Field extends FieldType {

	const NAME = 'diviner_taxonomy_field';
	const TITLE = 'Taxonomy Field';
	const TYPE = 'taxonomy';

	/**
	 * Outputs nothing because taxonomies are handled like all WP taxonomies
	 *
	 */
	static public function render( $post_id, $id, $field_label, $helper = '') {
		return '';
	}

	static public function setup( $post_id ) {
		$field_label_singular = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SINGULAR_LABEL);
		$field_label_plural = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_PLURAL_LABEL);
		$field_slug = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SLUG);
		$field_tax_type = carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_TYPE);

		if ( empty( $field_slug ) ) {
			$field_slug = sanitize_title($field_label_singular);
		}

		if ( empty( $field_label_singular ) ) {
			$field_label_singular = sprintf(
				'Taxonomy %d',
				$post_id
			);
		}

		if ( empty( $field_label_plural ) ) {
			$field_label_plural = sprintf(
				__( 'Taxonomies %d', 'ncpr-diviner' ),
				$post_id
			);
		}

		// Labels
		$labels = array(
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
		);

		// args
		$args = array(
			'hierarchical'      => ( $field_tax_type === FieldPostMeta::FIELD_TAXONOMY_TYPE_CATEGORY ) ? true : false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => $field_slug
			),
			'show_in_rest'      => true,
		);
		register_taxonomy( self::get_taxonomy_name( $post_id ), array( Archive_Item::NAME ), $args );

	}

	static public function get_taxonomy_name( $post_id ) {
		return sprintf(
			'%s_%s',
			self::NAME,
			$post_id
		);
	}

	static public function get_blueprint( $post_id ) {
		$blueprint = parent::get_blueprint( $post_id );
		$additional_vars = [
			'taxonomy_field_type'  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_TYPE),
			'taxonomy_field_slug'  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SLUG),
			'taxonomy_field_singular_label'  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_SINGULAR_LABEL),
			'taxonomy_field_plural_label'  => carbon_get_post_meta( $post_id, FieldPostMeta::FIELD_TAXONOMY_PLURAL_LABEL),
			'taxonomy_field_name'   => self::get_taxonomy_name( $post_id ),
		];
		// add all taxonomy terms
		// should this be done asynchronisely


		return array_merge($blueprint, $additional_vars);
	}
}
