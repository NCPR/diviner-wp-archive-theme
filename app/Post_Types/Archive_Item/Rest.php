<?php

namespace Diviner\Post_Types\Archive_Item;

class Rest {

	protected $container;

	public function hooks() {
		add_action( 'rest_api_init', array( &$this,'custom_register_rest_fields') );
	}

	public function custom_register_rest_fields()
	{
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
