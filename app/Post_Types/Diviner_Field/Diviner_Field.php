<?php


namespace Diviner\Post_Types\Diviner_Field;


class Diviner_Field {

	const NAME = 'diviner_field';

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		register_post_type( self::NAME, $args );
	}

	public function get_args() {
		return [
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'excerpt' ),
			'has_archive'        => false,
			'rewrite'            => false,
			'exclude_from_search' => true,
		];
	}

	public function get_labels() {
		return [
			'labels' => [
				'singular' => __( 'Diviner Field', 'tribe' ),
				'plural'   => __( 'Diviner Fields', 'tribe' ),
				'slug'     => _x( 'diviner-field', 'post type slug', 'diviner' ),
				'name'     => _x( 'Diviner Fields', 'post type general name')
			]
		];
	}
}
