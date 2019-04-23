<?php


namespace Diviner\Theme;

use \Diviner\Admin\Settings;

/**
 * Setting up the Browse page at startup
 *
 * @package Diviner\Admin
 */
class Search_Page {

	const THEME_OPTION_SEARCH_PAGE_CREATED = 'diviner_theme_option_searchpage_created';

	public function hooks() {
		if ( DIVINER_IS_THEME ) {
			add_action( 'after_switch_theme', [ $this, 'setup_search_page' ] );
			add_action( 'theme/header/end', [ $this, 'action_header_end' ]);
		}
	}

	/**
	 * Action to output the search icon
	 *
	 */
	public function action_header_end() {
		$searchpage = carbon_get_theme_option(Settings::FIELD_GENERAL_NAV_SEARCH_PAGE );
		if ( !empty( $searchpage ) ) {
			printf(
				'<a class="header__menu-search" href="%s"><span class="fas fa-search"></span><div class="a11y-hidden">%s</div></a>',
				get_permalink( $searchpage ),
				__( 'Search', 'ncpr-diviner')
			);
			?>
			<?php
		}
	}

	/**
	 * Gets first page with the search template
	 *
	 * @return int post id
	 */
	public function get_current_search_page() {
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-search.php'
		];
		$current_search_pages = get_posts($args);
		if ( is_array( $current_search_pages ) && count( $current_search_pages ) > 0 ) {
			return $current_search_pages[0];
		}
		return 0;
	}

	/**
	 * do we have a search page
	 */
	public function already_have_search_page() {
		$current_browse_page = $this->get_current_search_page();
		return isset( $current_browse_page ) && $current_browse_page > 0;
	}
	/**
	 * Create Search page
	 */
	public function create_search_page() {
		// Create page
		$search_page = array(
			'post_title'    => wp_strip_all_tags( __( 'Search', 'ncpr-diviner' ) ),
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'     => 'page',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
			'page_template'  => 'page-search.php'
		);

		// Insert the post into the database
		return wp_insert_post( $search_page );
	}

	/**
	 * Determines if a post, identified by the specified ID, exist
	 * within the WordPress database.
	 *
	 * @param    int    $id    The ID of the post to check
	 * @return   bool          True if the post exists; otherwise, false.
	 * @since    1.0.0
	 */
	function post_exists( $id ) {
		return is_string( get_post_status( $id ) );
	}

	/**
	 * Insert New Default Search Page
	 */
	public function insert_default_search_page() {
		$current_search = $this->get_current_search_page();
		if ( empty($current_search) ) {
			$current_search = $this->create_search_page();
		}
		if($current_search !== 0) {
			carbon_set_theme_option(Settings::FIELD_GENERAL_NAV_SEARCH_PAGE, $current_search );
		}
	}


	/**
	 * Init Search page
	 */
	public function setup_search_page() {
		$searchpage = carbon_get_theme_option(Settings::FIELD_GENERAL_NAV_SEARCH_PAGE );
		if ( empty( $searchpage ) || !$this->post_exists( $searchpage ) ) {
			$this->insert_default_search_page();
		}
	}

}
