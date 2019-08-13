<?php

namespace Diviner_Archive\Theme;

use Diviner_Archive\Post_Types\Archive_Item\Archive_Item;

/**
 * Title
 *
 * @package Diviner_Archive\Theme
 */
class Title {

	/**
	 * @return string
	 */
	public function get_title() {

		if ( is_front_page() ) {
			return '';
		}

		// Blog
		if ( is_home() ) {
			$page_object = get_queried_object();
			if ($page_object && !empty( $page_object->post_title ) ) {
				return get_queried_object()->post_title;
			} else {
				return __( 'Blog', 'diviner-archive' );
			}

		}

		// Search
		elseif ( is_search() ) {
			global $wp_query;
			return sprintf( __( 'Your search for <strong>%s</strong> returned <strong>%d</strong> results', 'diviner-archive' ), esc_attr( get_search_query() ), $wp_query->found_posts );
		}

		// 404
		elseif ( is_404() ) {
			return __( 'Page Not Found (Error 404)', 'diviner-archive' );
		}

		// Singular
		elseif ( is_singular() ) {
			return get_the_title();
		}

		// Archive Item
		elseif ( is_post_type_archive( Archive_Item::NAME ) ) {
			if ( ! have_posts() ) {
				return __( 'No Archive Items Found', 'diviner-archive' );
			}
			return __( 'Archive Items', 'diviner-archive' );
		}

		elseif ( ! have_posts() ) {
			return __( 'No Posts Found', 'diviner-archive' );
		}

		// Archives
		return get_the_archive_title();
	}

}
