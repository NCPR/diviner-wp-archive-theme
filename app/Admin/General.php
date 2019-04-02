<?php

namespace Diviner\Admin;

use function Tonik\Theme\App\asset_path;

/**
 * General
 *
 * @package Diviner\Admin
 */
class General {

	public function hooks() {
		add_action('admin_enqueue_scripts', [ $this, 'register_admin_scripts' ] );
		add_action('admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ]);

	}

	/**
	 * Update CSS within in Admin
	 *
	 * @return void
	 */
	function diviner_admin_style() {
		wp_register_style( 'admin-styles', get_template_directory_uri().'/public/css/admin.css', false, '1.0.0' );
		wp_enqueue_style( 'admin-styles' );
	}


	/**
	 * Registers admin script files.
	 *
	 * @return void
	 */
	function register_admin_scripts() {
		wp_enqueue_script('diviner_admin', asset_path('js/admin.js'), [], null, true);
	}

}
