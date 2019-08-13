<?php

namespace Diviner_Archive\Admin;


/**
 * General
 *
 * @package Diviner_Archive\Admin
 */
class Diviner_Archive_General {

	const PIMPLE_CONTAINER_NAME = 'admin.general';

	private $_pages = null;

	public function hooks() {

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

}
