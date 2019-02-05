<?php


namespace Diviner\Post_Types\Diviner_Field;

use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;
use Diviner\CarbonFields\Errors\UndefinedType;
use Diviner\CarbonFields\Helper;

class Diviner_Field {

	const NAME = 'diviner_field';

	const ORDER_BY_RELEVANCE = '';
	const ORDER_BY_TITLE = 'SORT_TITLE';
	const ORDER_BY_PUBLICATION_DATE = 'SORT_PUBLICATION_DATE';

	public function __construct() {
	}

	public function hooks() {
		add_action( 'init', [ &$this,'register' ], 0, 0 );
		add_filter( 'diviner_js_config', [ $this, 'custom_diviner_js_config' ] );
	}

	public function register() {
		$args = wp_parse_args( $this->get_args(), $this->get_labels() );
		register_post_type( static::NAME, $args );
	}

	static public function get_active_fields($additional_meta_query = []) {
		$meta_query = [
			[
				'key'     => Helper::get_real_field_name(PostMeta::FIELD_ACTIVE ),
				'value'   => PostMeta::FIELD_CHECKBOX_VALUE
			],
		];
		if (count($additional_meta_query)) {
			$meta_query[] = [
				'relation'		=> 'AND',
			];
			$meta_query[] = $additional_meta_query;
		}
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => static::NAME,
			'meta_query' => $meta_query
		];
		return get_posts($args);
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
			'supports'           => [ 'title', 'excerpt' ],
			'has_archive'        => false,
			'rewrite'            => false,
			'exclude_from_search' => true,
		];
	}

	public function get_labels() {
		return [
			'labels' => [
				'singular'     => __( 'Diviner Field', 'ncpr-diviner' ),
				'plural'       => __( 'Diviner Fields', 'ncpr-diviner' ),
				'slug'         => _x( 'diviner-field', 'post type slug', 'diviner' ),
				'name'         => _x( 'Diviner Fields', 'post type general name'),
				'add_new_item' => __( 'Add New Diviner Field', 'ncpr-diviner' ),
				'edit_item'    => __( 'Edit Diviner Field', 'ncpr-diviner' ),
				'new_item'     => __( 'New Diviner Field', 'ncpr-diviner' ),
				'view_item'    => __( 'View Diviner Field', 'ncpr-diviner' ),
				'view_items'   => __( 'View Diviner Fields', 'ncpr-diviner' )
			]
		];
	}

	static public function get_class_title( $field_type ) {
		$field = Diviner_Field::get_class($field_type);
		$field_title_string = sprintf('%s::TITLE', $field);
		if ( defined( $field_title_string ) ) {
			return constant( $field_title_string );
		}
		return 'NONE';
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

	public function get_field_taxonomy_terms( $field_id, $field_name ) {
		return get_terms( $field_name );
	}

	public function get_field_cpt_posts( $field_id, $field_cpt_id ) {
		$args = [
			'posts_per_page' => -1,
			'post_type' => $field_cpt_id,
		];
		return get_posts($args);
	}

	/**
	 * Get Order by Options for JS
	 *
	 * @return array   Array of value/labels
	 */
	public function get_order_by_options() {
		$defaults = [
			[
				'value' => static::ORDER_BY_PUBLICATION_DATE,
				'label' => __( 'Publish Date', 'ncpr-diviner' ),
			],
			[
				'value' => static::ORDER_BY_TITLE,
				'label' => __( 'Title', 'ncpr-diviner' ),
			],
		];

		$fields = static::get_active_fields([
			'key'     => Helper::get_real_field_name(PostMeta::FIELD_BROWSE_IS_SORTABLE ),
			'value'   => PostMeta::FIELD_CHECKBOX_VALUE
		]);
		$dyn = [];
		foreach($fields as $field_id) {
			$field_type = carbon_get_post_meta($field_id, PostMeta::FIELD_TYPE );
			$field      = Diviner_Field::get_class($field_type);
			if( is_callable( [ $field, 'get_sort_options' ] ) ){
				$options    = call_user_func( [ $field, 'get_sort_options' ], $field_id);
				$dyn        = array_merge($dyn, $options);
			}
		}

		return array_merge($defaults, $dyn);
	}

	public function custom_diviner_js_config( $data  ) {
		$taxonomy_terms = [];
		$cpt_posts = [];
		$return = [];
		$fields = static::get_active_fields();
		foreach($fields as $field_id) {
			$field_type = carbon_get_post_meta($field_id, PostMeta::FIELD_TYPE, 'carbon_fields_container_field_variables');
			$field = Diviner_Field::get_class($field_type);
			$blueprint = call_user_func( [ $field, 'get_blueprint' ], $field_id);
			$blueprint['field_type'] = $field_type;
			$return[] = $blueprint;
			// add to taxonomy
			if ($field_type===Taxonomy_Field::NAME) {
				$taxonomy_terms[$blueprint['taxonomy_field_name']] = $this->get_field_taxonomy_terms( $field_id, $blueprint['taxonomy_field_name']);
			}
			// add CPT posts
			if ($field_type===CPT_Field::NAME) {
				$cpt_posts[$blueprint['cpt_field_id']] = $this->get_field_cpt_posts( $field_id, $blueprint['cpt_field_id']);
			}
		}
		$data['fields'] = $return;
		$data['taxonomies'] = $taxonomy_terms;
		$data['cpt_posts'] = $cpt_posts;
		$data['order_by'] = $this->get_order_by_options();
		return $data;

	}

}
