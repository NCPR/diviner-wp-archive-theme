<?php


namespace Diviner\Post_Types\Diviner_Field;

use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;
use Diviner\CarbonFields\Errors\UndefinedType;

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

	static public function get_class( $field_type ) {
		$map = [
			Text_Field::NAME        => Text_Field::class,
			Date_Field::NAME        => Date_Field::class,
			CPT_Field::NAME         => CPT_Field::class,
			Related_Field::NAME     => Related_Field::class,
			Taxonomy_Field::NAME    => Taxonomy_Field::class,
			Select_Field::NAME    => Select_Field::class,
		];
		if( !array_key_exists( $field_type, $map ) ){
			throw UndefinedType("{$field_type} is not a valid field type");
		}
		return $map[$field_type];
	}

}
