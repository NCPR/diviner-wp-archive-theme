<?php


namespace Diviner\Post_Types\Archive_Item;

use function Tonik\Theme\App\config;

class Archive_Item {

	const NAME = 'diviner_archive_item';

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		register_post_type( self::NAME, $args );
	}

	public function get_args() {
		return [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'archive-item' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			'map_meta_cap'       => true,
			// 'has_archive'     => _x( 'archive-item', 'post archive slug', 'tribe' ),
		];
	}

	public function get_labels() {
		return [
			'labels' => [
				'singular' => __( 'Archive Item', config('textdomain') ),
				'plural'   => __( 'Archive Items', config('textdomain') ),
				'slug'     => _x( 'archive-item', 'post type slug', config('textdomain') ),
				'name'     => _x( 'Archive Items', 'post type general name'),
				'add_new_item' => __( 'Add New Archive Item', config('textdomain') ),
			]
		];
	}
}
