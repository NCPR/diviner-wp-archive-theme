<?php

namespace Diviner\Admin;

use function Tonik\Theme\App\asset_path;

/**
 * General
 *
 * @package Diviner\Admin
 */
class General {

	const PIMPLE_CONTAINER_NAME = 'admin.general';

	private $_pages = null;

	public function hooks() {
		add_action('admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action('admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ]);
	}

	/**
	 * Cache of pages options for re-use in various places
	 *
	 * @return array
	 */
	public function get_pages() {
		if (!empty($this->_pages)) {
			return $this->_pages;
		}
		$cleaned = [
			0 => ''
		];
		$args = [
			'post_type'    => 'page',
			'sort_column'  => 'menu_order'
		];
		$pages = get_pages( $args );
		foreach ($pages as $page) {
			$cleaned[$page->ID] = $page->post_title;
		}
		$this->_pages = $cleaned;
		return $this->_pages;
	}

	/**
	 * Update CSS within in Admin
	 *
	 * @return void
	 */
	function enqueue_admin_styles() {
		wp_register_style(
			'admin-styles',
			get_template_directory_uri().'/public/css/admin.css',
			false,
			\Diviner\Theme\General::version()
		);
		wp_enqueue_style( 'admin-styles' );
	}


	/**
	 * Registers/Enqueues admin script files.
	 *
	 * @return void
	 */
	function enqueue_admin_scripts() {
		wp_enqueue_script(
			'diviner_admin',
			asset_path('js/admin.js'),
			[],
			\Diviner\Theme\General::version(),
			true
		);
	}

}
