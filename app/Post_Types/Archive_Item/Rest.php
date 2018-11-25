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
use Diviner\Admin\Settings;
use Diviner\CarbonFields\Helper;


class Rest {

	const FIELD_INDEX_ID = 'id';
	const FIELD_INDEX_TITLE = 'title';
	const FIELD_INDEX_TYPE = 'type';
	const FIELD_INDEX_FIELD_ID = 'field_id';
	const FIELD_INDEX_FIELD_POPUP = 'field_popup';

	protected $container;
	protected $fields;

	public function init() {
		$this->fields = $this->get_fields();
	}

	public function hooks() {
		add_filter( 'rest_' . Archive_Item::NAME . '_query', [$this, 'rest_api_filter_add_vars'], 10, 2 );
		add_filter( 'rest_' . Archive_Item::NAME . '_query', [$this, 'rest_api_filter_add_order_by'], 3, 2 );
		add_action( 'rest_api_init', array( &$this,'custom_register_rest_fields') );
	}

	protected function get_fields() {
		if (isset($this->fields)) {
			return $this->fields;
		}
		$meta_query = array(
			array(
				'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
				'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
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
				self::FIELD_INDEX_FIELD_POPUP => carbon_get_post_meta($post_id, FieldPostMeta::FIELD_BROWSE_DISPLAY, 'carbon_fields_container_field_variables'),
			];
		}
		$this->fields = $fields;
		return $this->fields;
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

		// error_log(print_r( $value, true ) , 3, "/Applications/MAMP/logs/php_error.log");

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

	public function decorate_text_args($field, $args, $request ) {
		if ( empty( $request[$field[self::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[self::FIELD_INDEX_FIELD_ID]];

		// error_log(print_r( $value, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$args[ 'meta_query' ][] = [
			'key'		=> $field[self::FIELD_INDEX_FIELD_ID],
			'value'		=> $value,
			'compare'	=> 'LIKE'
		];

		return $args;
	}

	public function decorate_select_args($field, $args, $request ) {
		if ( empty( $request[$field[self::FIELD_INDEX_FIELD_ID]] ) ) {
			return $args;
		}
		$value = $request[$field[self::FIELD_INDEX_FIELD_ID]];

		if ( ! isset($args[ 'meta_query' ])) {
			$args[ 'meta_query' ] = [
				'relation'		=> 'AND',
			];
		}
		$args[ 'meta_query' ][] = [
			'key'		=> $field[self::FIELD_INDEX_FIELD_ID],
			'value'		=> $value,
			'compare'	=> 'IN'
		];

		return $args;
	}

	public function decorate_date_args($field, $args, $request ) {
		if (empty($request[$field[self::FIELD_INDEX_FIELD_ID]])) {
			return $args;
		}
		$range = $request[$field[self::FIELD_INDEX_FIELD_ID]];

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
				'key'		=> $field[self::FIELD_INDEX_FIELD_ID],
				'compare'	=> '>=',
				'value'		=> $start_date,
			];
		}

		if (isset($range[1])) {
			$end_time = strtotime($range[1]);
			$end_date = date('Ymd', $end_time);
			$args[ 'meta_query' ][] = [
				'key'		=> $field[self::FIELD_INDEX_FIELD_ID],
				'compare'	=> '<=',
				'value'		=> $end_date,
			];
		}

		return $args;
	}

	public function rest_api_filter_add_vars( $args, $request ) {

		$fields = $this->get_fields();
		foreach($fields as $field) {
			if ($field[self::FIELD_INDEX_TYPE] === CPT_Field::NAME) {
				$args = $this->decorate_cpt_args($field, $args, $request );
			}
			if ($field[self::FIELD_INDEX_TYPE] === Taxonomy_Field::NAME) {
				$args = $this->decorate_taxonomy_args($field, $args, $request );
			}
			if ($field[self::FIELD_INDEX_TYPE] === Date_Field::NAME) {
				$args = $this->decorate_date_args($field, $args, $request );
			}

			if ($field[self::FIELD_INDEX_TYPE] === Select_Field::NAME) {
				$args = $this->decorate_select_args($field, $args, $request );
			}

			if ($field[self::FIELD_INDEX_TYPE] === Text_Field::NAME) {
				$args = $this->decorate_text_args($field, $args, $request );
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
				$sort_args = explode( '|', $custom_order );
				if (count($sort_args) == 3) {
					$args[ 'order' ] = ( $sort_args[2] == 'ASC' ) ? 'ASC' : 'DESC';
					$args[ 'meta_key' ] = Helper::get_real_field_name( $sort_args[1] );
					$args[ 'orderby' ] = 'meta_value_num';
				}
			}
		}

		// error_log(print_r( $args, true ) , 3, "/Applications/MAMP/logs/php_error.log");

		return $args;
	}

	public function get_fields_values( $fields, $id ) {
		$ret = [];
		foreach($fields as $field) {
			$field_id = carbon_get_post_meta( $field[self::FIELD_INDEX_ID],FieldPostMeta::FIELD_ID );
			$ret[$field_id] = carbon_get_post_meta( $id, $field_id);

		}
		return $ret;
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

		// only do this extra if the popup is used.
		$has_popup = carbon_get_theme_option(Settings::FIELD_GENERAL_BROWSE_MODAL);
		if (!$has_popup) {
			return;
		}

		// add CPT field vars
		$fields = $this->get_fields();
		$cpt_fields = array_filter($fields, function($field) {
			return $field[self::FIELD_INDEX_TYPE] === CPT_Field::NAME;
		});
		if ($cpt_fields) {
			register_rest_field( Archive_Item::NAME, 'cpts', array(
				'get_callback' => function( $arr ) use( &$cpt_fields) {
					return $this->get_fields_values( $cpt_fields, $arr['id']);
				}
			) );
		}

		// add Selects field vars
		$select_fields = array_filter($fields, function($field) {
			return $field[self::FIELD_INDEX_TYPE] === Select_Field::NAME;
		});
		if ($select_fields && count($select_fields)) {
			register_rest_field( Archive_Item::NAME, 'selects', array(
				'get_callback' => function( $arr ) use( &$select_fields) {
					return $this->get_fields_values( $select_fields, $arr['id']);
				}
			) );
		}

		$text_fields = array_filter($fields, function($field) {
			return $field[self::FIELD_INDEX_TYPE] === Text_Field::NAME;
		});
		if ($text_fields && count($text_fields)) {
			register_rest_field( Archive_Item::NAME, 'fields_text', array(
				'get_callback' => function( $arr ) use( &$text_fields) {
					return $this->get_fields_values( $text_fields, $arr['id']);
				}
			) );
		}

		// date field
		$date_fields = array_filter($fields, function($field) {
			return $field[self::FIELD_INDEX_TYPE] === Date_Field::NAME;
		});
		if ($date_fields && count($date_fields)) {
			register_rest_field( Archive_Item::NAME, 'fields_date', array(
				'get_callback' => function( $arr ) use( &$date_fields) {
					return $this->get_fields_values( $date_fields, $arr['id']);
				}
			) );
		}

		register_rest_field( Archive_Item::NAME, 'test', array(
			'get_callback' => function( $arr ) use( &$text_fields) {
				return count($text_fields);
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
