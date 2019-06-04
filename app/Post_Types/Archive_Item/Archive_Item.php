<?php


namespace Diviner\Post_Types\Archive_Item;

/**
 * Class Archive Item
 *
 * @package Diviner\Post_Types\Archive_Item
 */
class Archive_Item {

	const NAME = 'diviner_archive_item';

	public function hooks() {
		add_action( 'init', [ $this, 'register' ], 0, 0 );
	}

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		register_post_type( static::NAME, $args );
	}

	public function get_args() {
		return [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'archive-item' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_icon'          => 'dashicons-star-filled',
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'map_meta_cap'       => true,
			'show_in_rest'       => true,
			'rest_base'          => 'archival-items',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		];
	}

	public function get_labels() {
		return [
			'labels' => [
				'singular'     => _x( 'Archive Item', 'archive item', 'ncpr-diviner' ),
				'plural'       => _x( 'Archive Items', 'archive item', 'ncpr-diviner' ),
				'slug'         => _x( 'archive-item', 'archive item', 'ncpr-diviner' ),
				'name'         => _x( 'Archive Items', 'archive item', 'ncpr-diviner' ),
				'add_new_item' => _x( 'Add New Archive Item', 'archive item', 'ncpr-diviner' ),
				'edit_item'    => _x( 'Edit Archive Item', 'archive item', 'ncpr-diviner' ),
				// Overrides the “Featured Image” label
				'featured_image'        => _x( 'Thumbnail image', 'archive item', 'ncpr-diviner' ),
				// Overrides the “Set featured image” label
				'set_featured_image'    => _x( 'Set thumbnail image', 'archive item', 'ncpr-diviner' ),
				// Overrides the “Remove featured image” label
				'remove_featured_image' => _x( 'Remove thumbnail image', 'archive item', 'ncpr-diviner' ),
				// Overrides the “Use as featured image” label
				'use_featured_image'    => _x( 'Use as thumbnail image', 'archive item', 'ncpr-diviner' ),
			]
		];
	}
}
