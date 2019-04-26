<?php

namespace Diviner\Post_Types\Archive_Item;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\Post_Types\Diviner_Field\PostMeta;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;
use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Admin\Settings;
use Diviner\CarbonFields\Helper;
use Diviner\Config\General;

/**
 * Class Rest
 *
 * @package Diviner\Post_Types\Archive_Item
 */
class Rest {

	const FIELD_INDEX_ID = 'id';
	const FIELD_INDEX_TITLE = 'title';
	const FIELD_INDEX_TYPE = 'type';
	const FIELD_INDEX_FIELD_ID = 'field_id';
	const FIELD_INDEX_FIELD_POPUP = 'field_popup';
	const FIELD_INDEX_FIELD_ELASTIC = 'field_elastic';

	protected $container;
	protected $fields;

	public function hooks() {
		$achive_item_name = Archive_Item::NAME;
		add_filter( "rest_{$achive_item_name}_query", [ $this, 'rest_api_filter_add_vars' ], 10, 2 );
		add_filter( "rest_{$achive_item_name}_query", [ $this, 'rest_api_filter_add_order_by' ], 3, 2 );
		add_filter( "rest_{$achive_item_name}_query", [ $this, 'rest_api_enable_elastic' ], 11, 2 );
		add_filter( 'ep_formatted_args_query', [ $this, 'ep_formatted_args_query' ], 10, 2 );
		add_filter( 'ep_post_sync_args', [ $this, 'custom_ep_post_sync_args' ], 10, 2);
		add_action( 'rest_api_init', [ $this,'custom_register_rest_fields' ] );
	}

	function custom_ep_post_sync_args($post_args, $post_id) {
		$old_prepared_meta = !empty( $post_args['post_meta'] ) ? $post_args['post_meta'] : [];
		$additional_meta = [];

		$fields = $this->get_fields();
		$search_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_FIELD_ELASTIC] == (int)FieldPostMeta::FIELD_CHECKBOX_VALUE;
		});

		foreach($search_fields as $field) {
			$field_class = Diviner_Field::get_class($field[static::FIELD_INDEX_TYPE]);
			if (!empty($field_class) && is_callable([$field_class, 'decorate_ep_post_sync_args'])) {
				$additional_meta = call_user_func([$field_class, 'decorate_ep_post_sync_args'], $additional_meta, $post_id, $field, $field[static::FIELD_INDEX_FIELD_ID]);
			}
		}
		$new_prepared_meta = array_merge($old_prepared_meta, $additional_meta);
		$post_args['post_meta'] = $new_prepared_meta;

		return $post_args;
	}

	/**
	 * Enable Elastic search and add the active fields to the search
	 *
	 * @param array $args
	 * @param Object $request
	 *
	 * @return array
	 */
	function rest_api_enable_elastic( $args, $request ) {
		$args[ 'ep_integrate' ] = true;

		$fields = $this->get_fields();
		$search_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_FIELD_ELASTIC] == (int)FieldPostMeta::FIELD_CHECKBOX_VALUE;
		});

		$meta = [];
		$taxonomies = [];
		foreach($search_fields as $field) {
			switch ($field[static::FIELD_INDEX_TYPE]) {
				case CPT_Field::NAME:
					$meta[] = $field[static::FIELD_INDEX_ID];
					break;
				case Taxonomy_Field::NAME:
					$taxonomies[] = $field[static::FIELD_INDEX_ID];
					break;
				case Date_Field::NAME:
				case Select_Field::NAME:
					// cannot be added to the search
					break;
				case Text_Field::NAME:
					$meta[] = $field[static::FIELD_INDEX_ID];
					break;
			}
		}
		$args[ 'search_fields' ] = [
			'post_title',
			'post_content',
			'taxonomies' => $taxonomies,
			'meta' => $meta,
		];

		return $args;
	}

	/**
	 * Enable Elastic search
	 *
	 * @param string $search
	 * @param WP_Query $query
	 *
	 * @return string
	 */
	function ep_formatted_args_query( $query, $args ) {
		// change the ES search query
		// https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
		$query['bool']['should'][0]['multi_match']['type'] = 'most_fields';

		return $query;
	}

	protected function get_fields() {
		if (isset($this->fields)) {
			return $this->fields;
		}
		$meta_query = [
			'diviner_is_active' => [
				'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
				'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
			],
		];
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => Diviner_Field::NAME,
			'meta_query' => $meta_query
		];
		$fields = [];
		$posts_ids = get_posts($args);
		foreach($posts_ids as $post_id) {
			$new_field = [
				static::FIELD_INDEX_ID => $post_id,
				static::FIELD_INDEX_TITLE => get_the_title($post_id),
				static::FIELD_INDEX_TYPE => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_TYPE ),
				static::FIELD_INDEX_FIELD_ID => Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_ID ),
				static::FIELD_INDEX_FIELD_POPUP => (bool) Diviner_Field::get_field_post_meta( $post_id, FieldPostMeta::FIELD_BROWSE_DISPLAY ),
			];
			if ( defined( 'EP_VERSION' ) ) {
				// FIELD_INDEX_FIELD_ELASTIC
				$new_field[ static::FIELD_INDEX_FIELD_ELASTIC ] = Diviner_Field::get_field_post_meta($post_id, FieldPostMeta::FIELD_BROWSE_IS_ELASTIC);
			}
			$fields[] = $new_field;
		}
		$this->fields = $fields;
		return $this->fields;
	}

	public function decorate_taxonomy_args($field, $args, $request ) {
		if (empty($request[$field[static::FIELD_INDEX_FIELD_ID]])) {
			return $args;
		}
		return $args;
	}


	public function decorate_cpt_args($field, $args, $request ) {
		if ( empty( $request[$field[static::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[static::FIELD_INDEX_FIELD_ID]];

		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$field_cpt_id = Diviner_Field::get_field_post_meta( $field[static::FIELD_INDEX_ID],FieldPostMeta::FIELD_CPT_ID );
		if ( ! empty( $field_cpt_id )) {
			$args[ 'meta_query' ][] = [
				'key'		=> $field[static::FIELD_INDEX_FIELD_ID],
				'value'		=> sprintf('post:%s:%s',
					$field_cpt_id,
					$value
				),
				'compare'	=> '='
			];
		}
		return $args;
	}

	public function decorate_text_args($field, $args, $request ) {
		if ( empty( $request[$field[static::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[static::FIELD_INDEX_FIELD_ID]];

		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$args[ 'meta_query' ][] = [
			'key'		=> $field[static::FIELD_INDEX_FIELD_ID],
			'value'		=> $value,
			'compare'	=> 'LIKE'
		];

		return $args;
	}

	public function decorate_select_args($field, $args, $request ) {
		if ( empty( $request[$field[static::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[static::FIELD_INDEX_FIELD_ID]];

		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$args[ 'meta_query' ][] = [
			'key'		=> $field[static::FIELD_INDEX_FIELD_ID],
			'value'		=> $value,
			'compare'	=> 'IN'
		];

		return $args;
	}

	public function decorate_date_args($field, $args, $request ) {
		if (empty($request[$field[static::FIELD_INDEX_FIELD_ID]])) {
			return $args;
		}
		$range = $request[$field[static::FIELD_INDEX_FIELD_ID]];

		// assume the format is array of dates in format YYY/MM/DD
		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}

		if (isset($range[0])) {
			$start_time = strtotime($range[0]);
			$start_date = date("Ymd", $start_time);
			$args[ 'meta_query' ][] = [
				'key'		=> $field[static::FIELD_INDEX_FIELD_ID],
				'compare'	=> '>=',
				'value'		=> $start_date,
				'type'		=> 'DATE'
			];
		}

		if (isset($range[1])) {
			$end_time = strtotime($range[1]);
			$end_date = date('Ymd', $end_time);
			$args[ 'meta_query' ][] = [
				'key'		=> $field[static::FIELD_INDEX_FIELD_ID],
				'compare'	=> '<=',
				'value'		=> $end_date,
			];
		}

		return $args;
	}

	public function rest_api_filter_add_vars( $args, $request ) {

		$fields = $this->get_fields();
		foreach($fields as $field) {
			switch ($field[static::FIELD_INDEX_TYPE]) {
				case CPT_Field::NAME:
					$args = $this->decorate_cpt_args($field, $args, $request );
					break;
				case Taxonomy_Field::NAME:
					$args = $this->decorate_taxonomy_args($field, $args, $request );
					break;
				case Date_Field::NAME:
					$args = $this->decorate_date_args($field, $args, $request );
					break;
				case Select_Field::NAME:
					$args = $this->decorate_select_args($field, $args, $request );
					break;
				case Text_Field::NAME:
					$args = $this->decorate_text_args($field, $args, $request );
					break;
			}
		}

		return $args;
	}

	/**
	 * Adds the order by meta
	 *
	 * @param  Object $args    Request arguments.
	 * @return Object $args    Altered request arguments.
	 */
	function rest_api_filter_add_order_by( $args, $request ) {
		$custom_order = $request['order_by'];

		global $wp;
		if ( empty( $request['order_by'] ) ) {
			$args[ 'orderby' ] = 'relevance';
		} else {

			if ( $custom_order == Diviner_Field::ORDER_BY_TITLE ) {
				$args[ 'order' ] = 'ASC';
				$args[ 'orderby' ] = 'title';
			} else if ( $custom_order == Diviner_Field::ORDER_BY_PUBLICATION_DATE ) {
				$args[ 'order' ] = 'ASC';
				$args[ 'orderby' ] = 'date';
			} else if ( substr( $custom_order, 0, 5 ) === "SORT|" ) {
				// decorate the args based on each field (currently only text and date)
				$sort_args = explode( '|', $custom_order );
				if (count($sort_args) == 4) {
					$field = Diviner_Field::get_class($sort_args[1]);
					if ( ! empty( $field ) && is_callable( [ $field, 'decorate_query_args' ] ) ) {
						$args = call_user_func( [ $field, 'decorate_query_args' ], $args, $sort_args);
					}
				}
			}
		}

		return $args;
	}

	public function get_fields_values( $fields, $id ) {
		$ret = [];
		foreach($fields as $field) {
			$field_id = Diviner_Field::get_field_post_meta( $field[static::FIELD_INDEX_ID],FieldPostMeta::FIELD_ID );
			$ret[$field_id] = carbon_get_post_meta( $id, $field_id );

		}
		return $ret;
	}

	public function custom_register_rest_fields() {

		register_rest_field( Archive_Item::NAME, 'feature_image', [
			'get_callback' => function( $arr ) {
				$post_thumbnail_id = get_post_thumbnail_id( $arr['id'] );
				return $this->get_image_data_for_api($post_thumbnail_id);
			}
		] );

		register_rest_field( Archive_Item::NAME, 'permalink', [
			'get_callback' => function( $arr ) {
				return get_the_permalink($arr['id']);
			}
		] );

		register_rest_field( Archive_Item::NAME, 'div_ai_field_type', [
			'get_callback' => function( $arr ) {
				return carbon_get_post_meta( $arr['id'], Post_Meta::FIELD_TYPE );
			}
		] );

		// only do this extra if the popup is used.
		$has_popup = carbon_get_theme_option(Settings::FIELD_GENERAL_BROWSE_MODAL);
		if (!$has_popup) {
			return;
		}

		// add CPT field vars
		$fields = $this->get_fields();
		$cpt_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_TYPE] === CPT_Field::NAME;
		});
		if ($cpt_fields) {
			register_rest_field( Archive_Item::NAME, 'cpts', [
				'get_callback' => function( $arr ) use( &$cpt_fields) {
					return $this->get_fields_values( $cpt_fields, $arr['id']);
				}
			] );
		}

		// add Selects field vars
		$select_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_TYPE] === Select_Field::NAME;
		});
		if ($select_fields && count($select_fields)) {
			register_rest_field( Archive_Item::NAME, 'selects', [
				'get_callback' => function( $arr ) use( &$select_fields) {
					return $this->get_fields_values( $select_fields, $arr['id']);
				}
			] );
		}

		$text_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_TYPE] === Text_Field::NAME;
		});
		if ($text_fields && count($text_fields)) {
			register_rest_field( Archive_Item::NAME, 'fields_text', [
				'get_callback' => function( $arr ) use( &$text_fields) {
					return $this->get_fields_values( $text_fields, $arr['id']);
				}
			] );
		}

		// date field
		$date_fields = array_filter($fields, function($field) {
			return $field[static::FIELD_INDEX_TYPE] === Date_Field::NAME;
		});
		if ($date_fields && count($date_fields)) {
			register_rest_field( Archive_Item::NAME, 'fields_date', [
				'get_callback' => function( $arr ) use( &$date_fields) {
					return $this->get_fields_values( $date_fields, $arr['id']);
				}
			] );
		}


	}

	public function get_image_data_for_api( $data ) {

		$all_sizes_data = [ ];

		// Full is the only guaranteed size, so it's going to be our default
		$full_size_data = wp_get_attachment_image_src( $data, 'full' );

		// Something went wrong. Most likely the attachment was deleted.
		if ( $full_size_data === false ) {
			return false;
		}

		$attachment = get_post( $data );

		$return_data = [
			'url'         => $full_size_data[0],
			'width'       => $full_size_data[1],
			'height'      => $full_size_data[2],
			'title'       => $attachment->post_title,
			'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'description' => $attachment->post_content,
			'caption'     => $attachment->post_excerpt,
		];

		$all_sizes_data[ 'full' ] = [
			'url'    => $full_size_data[0],
			'width'  => $full_size_data[1],
			'height' => $full_size_data[2],
		];

		$sizes_in_rest  = [
			General::IMAGE_SIZE_BROWSE_GRID,
			General::IMAGE_SIZE_BROWSE_POPUP,
			'thumbnail' // for fallback
		];

		// Set all the other sizes
		foreach ( get_intermediate_image_sizes() as $size ) {

			if ( $size === 'full' ) {
				continue;
			}
			// limit sizes to only
			if ( !in_array($size, $sizes_in_rest ) ) {
				continue;
			}

			$size_data = wp_get_attachment_image_src( $data, $size );

			if ( $size_data === false ) {
				continue;
			}

			// ignore if the URL value is the same as with the full
			if ( $full_size_data[0] === $size_data[0] ) {
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
