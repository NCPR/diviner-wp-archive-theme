<?php

namespace Diviner\Post_Types\Archive_Item;

use Carbon_Fields\Field;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\CarbonFields\Helper;


class Rest {

	const FIELD_INDEX_ID = 'id';
	const FIELD_INDEX_TITLE = 'title';
	const FIELD_INDEX_TYPE = 'type';
	const FIELD_INDEX_FIELD_ID = 'field_id';

	protected $container;
	protected $fields;

	public function hooks() {
		$action = 'after_setup_theme';
		if ( DIVINER_IS_PLUGIN ) {
			$action = 'plugins_loaded';
		}
		// add_filter( $action, [$this, 'init'], 10, 2 );
		add_filter( 'rest_' . Archive_Item::NAME . '_query', [$this, 'rest_api_filter_add_vars'], 10, 2 );
		add_action( 'rest_api_init', array( &$this,'custom_register_rest_fields') );
	}

	public function init() {
		$this->fields = $this->get_fields();
		var_dump('$this->fields ', $this->fields );
	}

	protected function get_fields() {
		$meta_query = array(
			array(
				'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
				'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
			),
			array(
				'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_BROWSE_PLACEMENT ),
				'value'   => FieldPostMeta::PLACEMENT_OPTIONS_NONE,
				'compare' => '!='
			),
		);
		$args = array(
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => Diviner_Field::NAME,
			'meta_query' => $meta_query
		);
		$fields = [];
		$posts_ids = get_posts($args);
		foreach($posts_ids as $post_id) {
			$fields[] = [
				self::FIELD_INDEX_ID => $post_id,
				self::FIELD_INDEX_TITLE => get_the_title($post_id),
				self::FIELD_INDEX_TYPE => carbon_get_post_meta($post_id, FieldPostMeta::FIELD_TYPE, 'carbon_fields_container_field_variables'),
				self::FIELD_INDEX_FIELD_ID => carbon_get_post_meta($post_id, FieldPostMeta::FIELD_ID, 'carbon_fields_container_field_variables'),
			];
		}
		return $fields;
	}

	public function decorate_taxonomy_args($field, $args, $request ) {
		if (empty($request[$field[self::FIELD_INDEX_FIELD_ID]])) {
			return $args;
		}
		return $args;
	}


	public function decorate_cpt_args($field, $args, $request ) {
		if ( empty( $request[$field[self::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[self::FIELD_INDEX_FIELD_ID]];

		error_log(print_r( $value, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		global $wp;
		$vars = apply_filters( 'query_vars', $wp->public_query_vars );
		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$field_cpt_id = carbon_get_post_meta( $field[self::FIELD_INDEX_ID],FieldPostMeta::FIELD_CPT_ID );
		$args[ 'meta_query' ][] = [
			'key'		=> $field[self::FIELD_INDEX_FIELD_ID],
			'value'		=> sprintf('post:%s:%s',
				$field_cpt_id,
				$value
			),
			'compare'	=> '='
		];

		return $args;
	}

	public function rest_api_filter_add_vars( $args, $request ) {
		$fields = $this->get_fields();
		foreach($fields as $field) {
			if ($field[self::FIELD_INDEX_TYPE	] === CPT_Field::NAME) {
				$args = $this->decorate_cpt_args($field, $args, $request );
			}
			if ($field[self::FIELD_INDEX_TYPE	] === Taxonomy_Field::NAME) {
				$args = $this->decorate_taxonomy_args($field, $args, $request );
			}
		}

		// FIELD_ID

		// $location = $request['location'];

		// error_log(print_r( $location, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		// global $wp;
		// $vars = apply_filters( 'query_vars', $wp->public_query_vars );

		/*
		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$args[ 'meta_query' ][] = [
			'key'		=> 'field_archival_item_location',
			'value'		=> $location,
			'compare'	=> '='
		];
		*/

		// error_log(print_r( $args, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		error_log(print_r( $request, true ) , 3, "/Applications/MAMP/logs/php_error.log");
		error_log(print_r( $fields, true ) , 3, "/Applications/MAMP/logs/php_error.log");
		error_log(print_r( $args, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		return $args;

	}

	public function custom_register_rest_fields() {
		register_rest_field( Archive_Item::NAME, 'feature_image', array(
			'get_callback' => function( $arr ) {
				$post_thumbnail_id = get_post_thumbnail_id( $arr['id'] );
				// return $post_thumbnail_id;
				return $this->get_image_data_for_api($post_thumbnail_id);
			}
		) );

		register_rest_field( Archive_Item::NAME, 'permalink', array(
			'get_callback' => function( $arr ) {
				return get_the_permalink($arr['id']);
			}
		) );

		register_rest_field( Archive_Item::NAME, 'test', array(
			'get_callback' => function( $arr ) {
				return 'helloe world';
			}
		) );
	}

	public function get_image_data_for_api( $data ) {

		$all_sizes_data = [ ];

		// Full is the only guaranteed size, so it's going to be our default
		$size_data = wp_get_attachment_image_src( $data, 'full' );

		// Something went wrong. Most likely the attachment was deleted.
		if ( $size_data === false ) {
			return new \stdClass;
		}

		$attachment = get_post( $data );

		$return_data = [
			'url'         => $size_data[0],
			'width'       => $size_data[1],
			'height'      => $size_data[2],
			'title'       => $attachment->post_title,
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'description' => $attachment->post_content,
			'caption'     => $attachment->post_excerpt,
		];

		// Set all the other sizes

		foreach ( get_intermediate_image_sizes() as $size ) {

			if ( $size === 'full' ) {
				continue;
			}

			$size_data = wp_get_attachment_image_src( $data, $size );

			if ( $size_data === false ) {
				continue;
			}

			$all_sizes_data[ $size ] = [
				'url'    => $size_data[0],
				'width'  => $size_data[1],
				'height' => $size_data[2],
			];
		}

		$return_data['sizes'] = $all_sizes_data;

		$return_object = new \stdClass();
		foreach ( $return_data as $key => $value ) {
			$return_object->$key = $value;
		}

		return $return_object;
	}

}