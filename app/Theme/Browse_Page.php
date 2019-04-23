<?php


namespace Diviner\Theme;

use Diviner\Admin\Settings;

/**
 * Setting up the Browse page at startup
 *
 * @package Diviner\Admin
 */
class Browse_Page {

	public function hooks() {
		if ( DIVINER_IS_THEME ) {
			add_action( 'after_switch_theme', [ $this, 'setup_browse_page' ] );
			add_action( 'admin_bar_menu', [ $this, 'add_admin_menu_button' ], 90);
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
			add_filter( 'diviner_js_config', [ $this, 'filter_diviner_js_config' ] );
			add_action( 'theme/header/before-title', [$this, 'before_title']);
		}
	}

	/**
	 * Displays the help page if its set and if on the browse page
	 *
	 */
	function before_title() {
		if (is_page_template('page-browser.php')) {
			$help_page_link = carbon_get_theme_option(Settings::FIELD_GENERAL_HELP_PAGE );
			if (!empty($help_page_link)) {
				printf(
					'<a href="%s" class="a-help-link">%s</a>',
					get_the_permalink($help_page_link),
					get_the_title($help_page_link)
				);
			}
		}
	}

	/**
	 * Browse Page Localization
	 *
	 */
	function get_browse_page_localization() {
		return [
			'popup_permission_statement' => __( 'Permissions Statement', 'ncpr-diviner' ),
			'popup_view_details' => __( 'View Details', 'ncpr-diviner' ),
			'popup_previous' => __( 'Previous', 'ncpr-diviner' ),
			'popup_next' => __( 'Next', 'ncpr-diviner' ),
			'grid_default' => __( 'Happy searching!!', 'ncpr-diviner' ),
			'grid_loading' => __( 'Loading', 'ncpr-diviner' ),
			'grid_no_results' => __( 'No Results Found', 'ncpr-diviner' ),
			'paginate_previous' => __( 'Previous', 'ncpr-diviner' ),
			'paginate_next' => __( 'Next', 'ncpr-diviner' ),
			'search_header' => __( 'Search Archive', 'ncpr-diviner' ),
			'search_placeholder' => __( 'Ex: cheese factory, grocery store, mine...', 'ncpr-diviner' ),
			'search_cta' => __( 'Go', 'ncpr-diviner' ),
			'facets_header' => __( 'Narrow Results By:', 'ncpr-diviner' ),
			'facets_sort_label' => __( 'Sort By:', 'ncpr-diviner' ),
			'facets_sort_clear' => __( 'Clear Order', 'ncpr-diviner' ),
			'facets_reset' => __( 'Reset Search Filters','ncpr-diviner' )
		];
	}

	/**
	 * Filter config js data
	 *
	 */
	function filter_diviner_js_config( $data ) {
		$browse_page = $this->get_current_browse_page();
		$is_current_browse = $this->is_current_page_browse();
		$browse_page_id = $is_current_browse ? get_the_ID() : $browse_page;
		$permalink = get_permalink( $browse_page_id );

		$data = [
			'base_browse_url' => '/' . basename( $permalink ),
			'browse_page_title' => get_the_title( $browse_page_id ),
			'browse_page_localization' => $this->get_browse_page_localization()
		];
		return $data;
	}


	/**
	 * Enqueue scripts
	 *
	 */
	function enqueue_scripts() {
		$version = General::version();
		$app_scripts    = get_template_directory_uri().'/browse-app/dist/master.js';
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
			$app_scripts = apply_filters( 'browse_js_dev_path', $app_scripts );
		}
		wp_register_script( 'core-app-browse', $app_scripts );

		$js_config = new JS_Config();
		wp_localize_script( 'core-app-browse', 'diviner_config', $js_config->get_data() );
		wp_enqueue_script( 'core-app-browse', $app_scripts, [  ], $version, true );
	}

	/**
	 * Check to verify that a page is a browse page
	 *
	 * @return boolean
	 */
	public function is_current_page_browse() {
		return is_page_template('page-browser.php');
	}

	/**
	 * Gets first page with the browse template
	 *
	 * @return int post id
	 */
	public function get_current_browse_page() {
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-browser.php'
		];
		$current_browse_pages = get_posts($args);
		if ( is_array($current_browse_pages) && count( $current_browse_pages ) > 0 ) {
			return $current_browse_pages[0];
		}
		return 0;
	}

	/**
	 * do we have a browse page
	 */
	public function already_have_browse_page() {
		$current_browse_page = $this->get_current_browse_page();
		return isset( $current_browse_page ) && $current_browse_page > 0;
	}

	/**
	 * Add Preview Button
	 */
	public function add_admin_menu_button( $wp_admin_bar ) {
		$current_browse = $this->get_current_browse_page();
		if ( isset($current_browse) && $current_browse !== 0 ) {
			$args = array(
				'id' => 'diviner-custom-adminbar-button',
				'title' => __( 'View Diviner Browse Page', 'ncpr-diviner' ),
				'href' => get_the_permalink( $current_browse ),
				'meta' => array(
					'class' => 'wp-admin-bar--diviner-button'
				)
			);
			$wp_admin_bar->add_node($args);
		}

	}

	/**
	 * Init Browse page
	 */
	public function setup_browse_page() {

		// ensure that permalink structure isnt using the plain approach
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( $wp_rewrite->root . '/%postname%/' ); // custom post permalinks

		if ( !$this->already_have_browse_page() ) {
			// Create post object
			$browse_page = array(
				'post_title'    => wp_strip_all_tags( __( 'Diviner Browse', 'ncpr-diviner' ) ),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'page_template'  => 'page-browser.php'
			);

			// Insert the post into the database
			wp_insert_post( $browse_page );
		}

	}

}
