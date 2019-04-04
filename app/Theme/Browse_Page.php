<?php


namespace Diviner\Theme;

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
		}
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
