<?php

namespace Diviner\Theme;

use Diviner\Config\General;

/**
 * Class Image
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class Image {

	public function hooks() {
		add_filter( 'wp_get_attachment_image_attributes', [ $this, 'custom_post_thumbnail_sizes_attr' ], 10 , 3 );
	}

	function custom_responsive_image_sizes($sizes, $size) {
		// blog posts
		if ( in_array($size, [ General::IMAGE_SIZE_FEATURE_SM, General::IMAGE_SIZE_FEATURE_MD, General::IMAGE_SIZE_FEATURE_LRG ] ) ) {
			// default to return if condition is not met
			return '(max-width: 768px) 800w, (max-width: 1024px) 1200w, 2000w';
		}
		// default to return if condition is not met
		return '100vw';
	}

	/**
	 * Add custom image sizes attribute to enhance responsive image functionality
	 * for post thumbnails
	 *
	 * @param array $attr Attributes for the image markup.
	 * @param int   $attachment Image attachment ID.
	 * @param array $size Registered image size or flat array of height and width dimensions.
	 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
	 */
	function custom_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
		if ( 'post-thumbnail' === $size ) {
			is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
			! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
		return $attr;
	}


	/**
	 * Get the markup for an image
	 * using srcset and sizes
	 *
	 * @param int        $image
	 * @param string     $image_size_src
	 * @param string     $image_size_srcset
	 * @param string     $override_img_sizes
	 *
	 * @return string
	 */
	public static function get_image( $image, $image_size_src, $image_size_srcset, $is_lazy = false, $override_img_sizes ) {
		if ( ! wp_attachment_is_image( $image ) ) {
			return false;
		}

		if (!isset($image_size_srcset)) {
			$image_size_srcset = $image_size_src;
		}

		$image_id = get_post_thumbnail_id();
		$img_src = wp_get_attachment_image_url( $image_id, $image_size_src );
		$img_srcset = wp_get_attachment_image_srcset( $image_id, $image_size_srcset );
		$img_sizes = wp_calculate_image_sizes( $image_size_src, $img_src, null, $image_id );
		$img_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

		if ( in_array($image_size_src, [ General::IMAGE_SIZE_FEATURE_SM, General::IMAGE_SIZE_FEATURE_MD, General::IMAGE_SIZE_FEATURE_LRG ] ) ) { // if feature image
			$img_sizes = '(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w';
		}

		if ( $is_lazy ) {
			return sprintf(
				'<img data-src="%s" data-srcset="%s" data-sizes="%s" alt="%s" class="lazyload">',
				esc_attr( $img_src ),
				esc_attr( $img_srcset ),
				esc_attr( $img_sizes ),
				esc_attr( $img_alt )
			);
		}

		return sprintf(
			'<img src="%s" srcset="%s" sizes="%s" alt="%s">',
			esc_attr( $img_src ),
			esc_attr( $img_srcset ),
			esc_attr( $img_sizes ),
			esc_attr( $img_alt )
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
	 * @param string     $override_img_sizes
	 */
	public static function image( $image, $image_size_src, $image_size_srcset, $is_lazy = false, $override_img_sizes ) {
		echo static::get_image( $image, $image_size_src, $image_size_srcset, $is_lazy, $override_img_sizes );
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
