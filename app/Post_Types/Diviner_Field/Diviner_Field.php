<?php


namespace Diviner\Post_Types\Diviner_Field;

use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;
use Diviner\CarbonFields\Helper;


/**
 * Class Diviner Field
 *
 * @package Diviner\Post_Types\Diviner_Field
 */
class Diviner_Field {

	const NAME = 'diviner_field';

	const ORDER_BY_RELEVANCE = '';
	const ORDER_BY_TITLE = 'SORT_TITLE';
	const ORDER_BY_PUBLICATION_DATE = 'SORT_PUBLICATION_DATE';
	const CACHE_KEY_ACTIVE_FIELDS = 'CACHE_KEY_ACTIVE_FIELDS';

	public function __construct() {
	}

	public function hooks() {
		add_action( 'init', [ $this,'register' ], 0, 0 );
		add_filter( 'diviner_js_config', [ $this, 'custom_diviner_js_config' ] );
		add_action( 'init', [ $this, 'hydrate_cache' ], 0 );
		add_filter( 'carbon_fields_should_save_field_value', [ $this, 'filter_should_save_field_value' ], 10, 3 );
		add_filter( 'carbon_fields_should_delete_field_value_on_save', [ $this, 'filter_should_delete_field_value' ], 10, 2 );
	}

	/**
	 * Checks if a value is slug friendly lowercase and dash
	 *
	 * @param string $value
	 * @return boolean
	 */
	public function is_slugfriendly_string($value) {
		return preg_match('/^[a-z-]+$/', $value);
	}

	/**
	 * Checks if a value is machine readable lowercase and underscore
	 *
	 * @param string $value
	 * @return boolean
	 */
	public function is_machine_readable_string($value) {
		return preg_match('/^[a-z_]+$/', $value);
	}

	/**
	 * Checks if a value can be deleted
	 *
	 * @param bool $delete
	 * @param \Carbon_Fields\Field\Select_Field $field
	 * @return boolean
	 */
	public function filter_should_delete_field_value( $delete, $field ) {
		$value = $field->get_value();
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_SELECT_OPTIONS_VALUE ) ) {
			return $this->is_machine_readable_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_CPT_ID ) ) {
			return $this->is_machine_readable_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_CPT_SLUG ) ) {
			return $this->is_slugfriendly_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_TAXONOMY_SLUG ) ) {
			return $this->is_slugfriendly_string($value);
		}
		return true;
	}

	/**
	 * Checks if a value can be saved
	 *
	 * @param bool $save
	 * @param Mixed $value
	 * @param \Carbon_Fields\Field\Select_Field $field
	 * @return boolean
	 */
	public function filter_should_save_field_value( $save, $value, $field ) {
		// ToDo display notification
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_SELECT_OPTIONS_VALUE ) ) {
			return $this->is_machine_readable_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_CPT_ID ) ) {
			return $this->is_machine_readable_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_CPT_SLUG ) ) {
			return $this->is_slugfriendly_string($value);
		}
		if ( $field->get_name() === Helper::get_real_field_name(PostMeta::FIELD_TAXONOMY_SLUG ) ) {
			return $this->is_slugfriendly_string($value);
		}
		return true;
	}

	static public function set_field_post_meta($id, $post_meta_name, $value) {
		carbon_set_post_meta( (int) $id, $post_meta_name,  $value);
	}

	static public function get_field_post_meta($id, $post_meta_name, $container_id = 'carbon_fields_container_field_variables') {
		$key = sprintf(
			'%s%s',
			$id,
			Helper::get_real_field_name($post_meta_name)
		);
		$cached_value = wp_cache_get( $key );
		if ( $cached_value ) {
			return $cached_value;
		}
		$uncached_value = carbon_get_post_meta($id, $post_meta_name, $container_id);
		wp_cache_set( $key, $uncached_value );
		return $uncached_value;
	}

	public function hydrate_cache() {
		$active_field_posts_ids = static::get_active_fields();
		if ( count($active_field_posts_ids) === 0 ) {
			return;
		}
		global $wpdb;
		$table_name = $wpdb->postmeta;
		foreach ($active_field_posts_ids as &$id) {
			$sql = $wpdb->prepare(
				"SELECT `meta_key` AS `key`, `meta_value` AS `value` FROM {$table_name} WHERE `post_id` = %s ORDER BY `meta_key` ASC",
				$id
			);
			$field_post_meta_array = $wpdb->get_results($sql);
			// get the field type
			$fieldTypeObject = array_values(array_filter(
				$field_post_meta_array,
				function ($e) {
					return $e->key == Helper::get_real_field_name(PostMeta::FIELD_TYPE );
				}
			) );
			if ( $fieldTypeObject ) {
				$field = static::get_class( $fieldTypeObject[0]->value );
				if( is_callable( [ $field, 'hydrate_post_meta_cache' ] ) ){
					call_user_func( [ $field, 'hydrate_post_meta_cache' ], $id, $field_post_meta_array);
				}
			}
		}
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

		// used cached version if possible
		$query_string = http_build_query( $args );
		$cache_key = sprintf(
			'%s_%s',
			$query_string,
			static::CACHE_KEY_ACTIVE_FIELDS
		);
		$result = wp_cache_get( $cache_key );
		if ( false === $result ) {
			$result = get_posts($args);;
			wp_cache_set( $cache_key, $result );
		};
		return $result;
	}

	/**
	 * Args for register post type
	 *
	 * @return array
	 */
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
			'rewrite'            => false,
			'exclude_from_search' => true,
		];
	}

	/**
	 * Labels for register post type
	 *
	 * @return array
	 */
	public function get_labels() {
		return [
			'labels' => [
				'singular'     => __( 'Diviner Field', 'ncpr-diviner' ),
				'plural'       => __( 'Diviner Fields', 'ncpr-diviner' ),
				'slug'         => _x( 'diviner-field', 'post type slug', 'ncpr-diviner' ),
				'name'         => _x( 'Diviner Fields', 'post type general name', 'ncpr-diviner' ),
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
			Text_Field::NAME     => Text_Field::class,
			Date_Field::NAME     => Date_Field::class,
			CPT_Field::NAME      => CPT_Field::class,
			Related_Field::NAME  => Related_Field::class,
			Taxonomy_Field::NAME => Taxonomy_Field::class,
			Select_Field::NAME   => Select_Field::class,
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
			$field_type = Diviner_Field::get_field_post_meta($field_id, PostMeta::FIELD_TYPE );
			$field      = Diviner_Field::get_class($field_type);
			if( is_callable( [ $field, 'get_sort_options' ] ) ){
				$options    = call_user_func( [ $field, 'get_sort_options' ], $field_id);
				$dyn        = array_merge($dyn, $options);
			}
		}

		return array_merge($defaults, $dyn);
	}

	/**
	 * Add the divinr field related data
	 *
	 * @param  array $data JS config data to be dropped into page as JSON
	 * @return array       Altered data
	 */
	public function custom_diviner_js_config( $data  ) {
		if ( !is_page_template('page-browser.php') ) {
			return $data;
		}

		$taxonomy_terms = [];
		$cpt_posts = [];
		$return = [];
		$fields = static::get_active_fields();
		foreach($fields as $field_id) {
			$field_type = Diviner_Field::get_field_post_meta($field_id, PostMeta::FIELD_TYPE );
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
		$data['taxonomies'] = $taxonomy_terms; //ToDo make this dynamic
		$data['cpt_posts'] = $cpt_posts; // ToDo make this dynamic
		$data['order_by'] = $this->get_order_by_options();
		return $data;

	}

}
