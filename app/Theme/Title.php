<?php

namespace Diviner\Theme;

use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Post_Types\Collection\Collection;

/**
 * Title
 *
 * @package Diviner\Theme
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
				return __( 'Blog', 'ncpr-diviner' );
			}

		}

		// Search
		elseif ( is_search() ) {
			global $wp_query;
			return sprintf( __( 'Your search for <strong>%s</strong> returned <strong>%d</strong> results', 'ncpr-diviner' ), esc_attr( get_search_query() ), $wp_query->found_posts );
		}

		// 404
		elseif ( is_404() ) {
			return __( 'Page Not Found', 'ncpr-diviner' );
		}

		// Singular
		elseif ( is_singular() ) {
			return get_the_title();
		}

		// Archive Item
		elseif ( is_post_type_archive( Archive_Item::NAME ) ) {
			if ( ! have_posts() ) {
				return __( 'No Archive Items Found', 'ncpr-diviner' );
			}
			return __( 'Archive Items', 'ncpr-diviner' );
		}

		// Collections
		elseif ( is_post_type_archive( Collection::NAME ) ) {
			$collections_plural = Collection::get_plural_title();
			if ( ! have_posts() ) {
				return sprintf(
					__( 'No %s Found', 'ncpr-diviner' ),
					$collections_plural
				);
			}
			return $collections_plural;
		}

		elseif ( ! have_posts() ) {
			return __( 'No Posts Found', 'ncpr-diviner' );
		}

		// Archives
		return get_the_archive_title();
	}

}
