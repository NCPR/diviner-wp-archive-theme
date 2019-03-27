<?php


namespace Diviner\Post_Types\Collection;

use Diviner\Admin\Settings;

/**
 * Class Collection
 *
 * @package Diviner\Post_Types\Collection
 */
class Collection {

	const NAME = 'diviner_collection';

	public function hooks() {
		// must take place after carbon_fields_register_fields
		add_action( 'init', [ $this, 'register' ], 1, 0 );
	}

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		$collections_active = carbon_get_theme_option(Settings::FIELD_GENERAL_COLLECTION);
		if ($collections_active ) {
			register_post_type( static::NAME, $args );
		}
	}

	public function get_args() {
		return [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'collections' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'show_in_rest'       => false,
		];
	}

	public function get_labels() {
		return [
			'labels' => [
				'singular'     => __( 'Collection', 'ncpr-diviner' ),
				'plural'       => __( 'Collections', 'ncpr-diviner' ),
				'slug'         => _x( 'collection', 'post type slug', 'ncpr-diviner' ),
				'name'         => _x( 'Collections', 'post type general name'),
				'add_new_item' => __( 'Add New Collection', 'ncpr-diviner' ),
				'edit_item'    => __( 'Edit Collection', 'ncpr-diviner' ),
			]
		];
	}
}
