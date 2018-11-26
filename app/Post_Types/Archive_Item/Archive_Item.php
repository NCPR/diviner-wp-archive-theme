<?php


namespace Diviner\Post_Types\Archive_Item;

use function Tonik\Theme\App\config;

class Archive_Item {

	const NAME = 'diviner_archive_item';

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
				'singular'     => __( 'Archive Item', 'ncpr-diviner' ),
				'plural'       => __( 'Archive Items', 'ncpr-diviner' ),
				'slug'         => _x( 'archive-item', 'post type slug', 'ncpr-diviner' ),
				'name'         => _x( 'Archive Items', 'post type general name'),
				'add_new_item' => __( 'Add New Archive Item', 'ncpr-diviner' ),
				'edit_item'    => __( 'Edit Archive Item', 'ncpr-diviner' ),
			]
		];
	}
}
