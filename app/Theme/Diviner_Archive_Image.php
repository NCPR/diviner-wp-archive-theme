<?php

namespace Diviner_Archive\Theme;

use Diviner_Archive\Config\Diviner_Archive_General;

/**
 * Class Image
 *
 * Functions Theme
 *
 * @package Diviner_Archive\Theme
 */
class Diviner_Archive_Image {

	public function hooks() {
	}


	/**
	 * Get the markup for an image
	 * using srcset and sizes
	 *
	 * @param int        $image
	 * @param string     $image_size_src
	 * @param string     $image_size_srcset
	 * @param array      $image_classes
	 *
	 * @return string
	 */
	public static function get_image( $image, $image_size_src, $image_size_srcset, $is_lazy = false, $image_classes = [] ) {
		if ( ! wp_attachment_is_image( $image ) ) {
			return false;
		}

		if (!isset($image_size_srcset)) {
			$image_size_srcset = $image_size_src;
		}

		$image_id = $image;
		$img_src = wp_get_attachment_image_url( $image_id, $image_size_src );
		$img_srcset = wp_get_attachment_image_srcset( $image_id, $image_size_srcset );
		$img_sizes = wp_calculate_image_sizes( $image_size_src, $img_src, null, $image_id );
		$img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		if ( in_array($image_size_src, [ Diviner_Archive_General::IMAGE_SIZE_FEATURE_SM, Diviner_Archive_General::IMAGE_SIZE_FEATURE_MD, Diviner_Archive_General::IMAGE_SIZE_FEATURE_LRG ] ) ) { // if feature image
			$img_sizes = '(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w';
		}

		if ($is_lazy) {
			$image_classes[] = 'lazyload';
		}

		if ( $is_lazy ) {
			return sprintf(
				'<img data-src="%s" data-srcset="%s" data-sizes="%s" alt="%s" class="%s">',
				esc_attr( $img_src ),
				esc_attr( $img_srcset ),
				esc_attr( $img_sizes ),
				esc_attr( $img_alt ),
				implode(" ",$image_classes)
			);
		}

		return sprintf(
			'<img src="%s" srcset="%s" sizes="%s" alt="%s" class="%s">',
			esc_attr( $img_src ),
			esc_attr( $img_srcset ),
			esc_attr( $img_sizes ),
			esc_attr( $img_alt ),
			implode(" ",$image_classes)
		);
	}

	/**
	 * Print the markup for an image
	 * using srcset and sizes
	 *
	 * @param int        $image
	 * @param string     $image_size_src
	 * @param string     $image_size_srcset
	 * @param bool       $is_lazy
	 * @param array      $image_classes
	 */
	public static function image( $image, $image_size_src, $image_size_srcset, $is_lazy = false, $image_classes = [] ) {
		echo static::get_image( $image, $image_size_src, $image_size_srcset, $is_lazy, $image_classes );
	}

	/**
	 * Get the markup for a bg image
	 * using srcset and sizes (https://github.com/verlok/lazyload)
	 *
	 * @param int        $image
	 * @param array      $image_sizes
	 *
	 * @return string
	 */
	public static function get_image_bg( $image, $image_sizes ) {
		if ( ! wp_attachment_is_image( $image ) ) {
			return false;
		}

		$image_id = get_post_thumbnail_id();
		$sizes = array_filter( array_map( function($image_size) use ($image_id)  {
			$size = wp_get_attachment_image_url( $image_id, $image_size );
			if (isset($size)) {
				return sprintf(
					'url(%s)',
					$size
				);
			}
			return null;
		}, $image_sizes));

		$img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		return sprintf(
			'<div data-bg="%s" aria-label="%s" class="lazyload" role="img" ></div>',
			esc_attr( implode( ', ', $sizes ) ),
			esc_attr( $img_alt )
		);
	}

	/**
	 * Print the markup for an image bg
	 * using srcset and sizes
	 *
	 * @param int        $image
	 * @param array      $image_sizes
	 */
	public static function image_bg( $image, $image_sizes ) {
		echo static::get_image_bg( $image, $image_sizes );
	}

}
