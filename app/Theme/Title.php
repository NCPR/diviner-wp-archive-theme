<?php

namespace Diviner\Theme;

use Diviner\Post_Types\Archive_Item\Archive_Item;

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
			return __( 'Blog', 'ncpr-diviner' );
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

		elseif ( ! have_posts() ) {
			return __( 'No Items Found', 'ncpr-diviner' );
		}


		// Archives
		return get_the_archive_title();
	}


	/**
	 * Sets up the proper title
	 *
	 * @since core 1.0
	 * @return string
	 */

	function get_page_title() {
		$title = new \Tribe\Project\Theme\Page_Title();
		return $title->get_title();
	}

}
