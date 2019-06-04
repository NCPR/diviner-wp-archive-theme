<?php


namespace Diviner\Post_Types\Collection;

use Diviner\Admin\Settings;
use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Theme\General;

/**
 * Class Collection
 *
 * @package Diviner\Post_Types\Collection
 */
class Collection {

	const NAME = 'diviner_collection';

	/**
	 * WP Hooks
	 *
	 * @return null
	 */
	public function hooks() {
		// must take place after carbon_fields_register_fields
		add_action( 'init', [ $this, 'register' ], 1, 0 );
	}

	/**
	 * Registers the Collections CPT if active
	 *
	 * @return null
	 */
	public function register() {
		$collections_active = carbon_get_theme_option(Settings::FIELD_GENERAL_COLLECTION );
		if ($collections_active ) {
			$args = wp_parse_args( $this->get_args(), $this->get_labels() );
			register_post_type( static::NAME, $args );
		}
	}

	/**
	 * Get Default Singular Title
	 *
	 * @return string
	 */
	static public function get_default_singular_title() {
		return _x( 'Collection', 'collection singular name', 'ncpr-diviner' );
	}

	/**
	 * Get Default Plural Title
	 *
	 * @return string
	 */
	static public function get_default_plural_title() {
		return _x( 'Collections', 'collection general name', 'ncpr-diviner' );
	}

	/**
	 * Get Singular Title
	 *
	 * @return string
	 */
	static public function get_singular_title() {
		$collections_singular = carbon_get_theme_option(Settings::FIELD_GENERAL_COLLECTION_SINGULAR);
		if (empty($collections_singular)) {
			$collections_singular = static::get_default_singular_title();
		}
		return $collections_singular;
	}

	/**
	 * Get Plural Title
	 *
	 * @return string
	 */
	static public function get_plural_title() {
		$collections_plural = General::get_theme_option(Settings::FIELD_GENERAL_COLLECTION_PLURAL);
		if (empty($collections_plural)) {
			$collections_plural = static::get_default_plural_title();
		}
		return $collections_plural;
	}

	/**
	 * Get Args
	 *
	 * @return array
	 */
	public function get_args() {
		$collections_plural = General::get_theme_option(Settings::FIELD_GENERAL_COLLECTION_PLURAL);
		return [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [
				'slug' => !empty( $collections_plural ) ? sanitize_title_with_dashes($collections_plural) : 'collections'
			],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'menu_icon'          => 'dashicons-star-filled',
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'supports'           => [
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt'
			],
		];
	}

	/**
	 * Get query for related archive items
	 *
	 * @return \WP_Query
	 *
	 */
	static public function get_archive_items_query($id = 0) {
		if (!$id) {
			$id = get_the_ID();
		}
		$archive_items = carbon_get_post_meta( $id, Post_Meta::FIELD_ARCHIVE_ITEMS);
		$ids = array_column( $archive_items, 'id' );
		$args = [
			'post_type'      => Archive_Item::NAME,
			'posts_per_page' => -1,
			'post__in'       => $ids,
			'orderby'        => 'date',
			'order'          => 'DESC',
		];

		// The Query
		return new \WP_Query( $args );
	}

	/**
	 * Returns dynamic labels
	 *
	 * @return array
	 */
	public function get_labels() {
		$collections_singular = static::get_singular_title();
		$collections_plural = static::get_plural_title();
		return [
			'labels' => [
				'name'               => $collections_plural,
				'singular_name'      => $collections_singular,
				'menu_name'          => $collections_plural,
				'name_admin_bar'     => $collections_singular,
				'add_new'            => _x( 'Add New', 'collection', 'ncpr-diviner' ),
				'add_new_item'       => sprintf(
					__( 'Add New %s', 'ncpr-diviner' ),
					$collections_singular
				),
				'new_item'           => sprintf(
					__( 'New %s', 'ncpr-diviner' ),
					$collections_singular
				),
				'edit_item'          => sprintf(
					__( 'Edit %s', 'ncpr-diviner' ),
					$collections_singular
				),
				'view_item'          => sprintf(
					__( 'View %s', 'ncpr-diviner' ),
					$collections_singular
				),
				'all_items'          => sprintf(
					__( 'All %s', 'ncpr-diviner' ),
					$collections_plural
				),
				'search_items'       => sprintf(
					__( 'Search %s', 'ncpr-diviner' ),
					$collections_plural
				),
				'parent_item_colon'  => sprintf(
					__( 'Parent %s:', 'ncpr-diviner' ),
					$collections_plural
				),
				'not_found'          => sprintf(
					__( 'No %s Found', 'ncpr-diviner' ),
					$collections_plural
				),
				'not_found_in_trash' => sprintf(
					__( 'No %s Found in Trash', 'ncpr-diviner' ),
					$collections_plural
				),
			]
		];
	}
}
