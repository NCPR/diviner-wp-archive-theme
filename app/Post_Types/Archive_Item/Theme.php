<?php

namespace Diviner\Post_Types\Archive_Item;

use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as DivinerFieldPostMeta;
use Diviner\Post_Types\Archive_Item\Post_Meta as Archive_Item_Post_Meta;
use Diviner\Config\General;


class Theme {

	public function hooks() {
		add_filter( 'embed_oembed_html', [ $this, 'wrap_oembed_html' ], 99, 4 );
	}

	static public function get_aspect_ratio($width, $height) {
		$rounded = round($width/$height, 2);
		switch ($rounded) {
			case 1.78:
				return '9-16';
				break;
			case 1.33:
				return '4-3';
				break;
			case 1:
				return '1-1';
				break;
			default:
				return "4-3";
		}
	}

	function wrap_oembed_html($html, $url, $attr, $post_id) {
		if (get_post_type() !== Archive_Item::NAME) {
			return $html;
		}
		$wmatches = [];
		$hmatches = [];
		$wid = 16;
		$hgt = 9;

		// Find Width and Height variables
		if (preg_match('/width=\"(\d+)\"/i', $html, $wmatches) && preg_match('/height=\"(\d+)\"/i', $html, $hmatches))
		{
			// and store them
			$wid = $wmatches[1];
			$hgt = $hmatches[1];
		}
		// Wrap the html in the container and also calculate the aspect ratio from the width and height and override the CSS in case it's different.
		$aspect = static::get_aspect_ratio($wid, $hgt);
		return sprintf(
			'<div class="video-oembed__container video-oembed__container--%s"><div class="video-oembed__inner">%s</div></div>',
			$aspect,
			$html
		);
	}

	static public function render_meta_fields($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}
		$active_field_posts_ids = Diviner_Field::get_active_fields();
		$field_output = [];


		foreach($active_field_posts_ids as $active_field_post_id) {
			$field_name = carbon_get_post_meta(
				$active_field_post_id,
				DivinerFieldPostMeta::FIELD_ID,
				'carbon_fields_container_field_variables'
			);
			$field_type = carbon_get_post_meta(
				$active_field_post_id,
				DivinerFieldPostMeta::FIELD_TYPE,
				'carbon_fields_container_field_variables'
			);
			// var_dump($field_type);
			$field_class = Diviner_Field::get_class($field_type);
			// var_dump($field_class);
			if( is_callable( [ $field_class, 'get_value' ] ) ) {
				$field_value = call_user_func( [ $field_class, 'get_value' ], $post_id, $field_name, $active_field_post_id);
			}
			// var_dump($field_value);
			$field_title = get_the_title( $active_field_post_id );
			if (isset($field_value)) {
				$field_output[] = sprintf(
					'<li class="archive-item-meta__item"><label class="archive-item-meta__item-label">%s</label><div class="archive-item-meta__item-value">%s</div></li>',
					$field_title,
					$field_value
				);
			}
		}
		 return sprintf(
		 	'<div class="archive-item-meta"><ul class="archive-item-meta__list">%s</ul></div>',
			 implode( '', $field_output)
		 );
	}

	static public function render_oembed_audio($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}
		$audio_oembed = carbon_get_post_meta( $post_id, Archive_Item_Post_Meta::FIELD_AUDIO_OEMBED );
		if ( empty($audio_oembed) ) {
			return '';
		}
		$embed = wp_oembed_get(
			$audio_oembed,
			[
				'width' => General::OEMBED_AUDIO_DIMENSIONS_WIDTH,
				'height' => General::OEMBED_AUDIO_DIMENSIONS_HEIGHT
			]
		);
		if( empty( $embed ) ) {
			return '';
		}
		return sprintf(
			'<div class="audio-oembed">%s</div>',
			$embed
		);
	}

	static public function render_audio($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}
		$audio = carbon_get_post_meta( $post_id, Archive_Item_Post_Meta::FIELD_AUDIO );
		if ( empty($audio) ) {
			return '';
		}
		$audio_attachment_url = wp_get_attachment_url( $audio );
		$shortcode = sprintf(
			'[audio src="%s"]',
			$audio_attachment_url
		);
		return sprintf(
			'<div class="audio-player">%s</div>',
			do_shortcode( $shortcode )
		);
	}

	static public function render_oembed_video($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}
		$video_oembed = carbon_get_post_meta( $post_id, Archive_Item_Post_Meta::FIELD_VIDEO_OEMBED);
		if ( empty($video_oembed) ) {
			return '';
		}
		global $wp_embed;
		$embed = $wp_embed->shortcode( array(), $video_oembed );
		if( empty( $embed ) ) {
			return '';
		}
		return sprintf(
			'<div class="video-oembed">%s</div>',
			$embed
		);
	}



	static public function render_document($post_id = null) {
		if (!isset($post_id)) {
			$post_id = get_the_ID();
		}

		// $audio_attachment_url = wp_get_attachment_url( $audio );
		$document = carbon_get_post_meta( $post_id, Archive_Item_Post_Meta::FIELD_DOCUMENT);
		if (empty($document)) {
			return '';
		}
		$document_attachment_url = wp_get_attachment_url( $document );

		return sprintf(
			'<a href="%s"><i class="fas fa-file"></i><span>%s</span></a>',
			$document_attachment_url,
			__( 'Download', 'ncpr-diviner' )
		);
	}

}
