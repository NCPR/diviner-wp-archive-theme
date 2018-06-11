<?php

namespace Diviner\CarbonFields;

use \Carbon_Fields\Carbon_Fields;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\CarbonFields
 */
class Boot {

	/**
	 * @return void
	 * @action init
	 */
	public function hook() {

		// add_filter( 'after_setup_theme', [ $this, 'after_setup_theme' ] );

	}

	/**
	 * Example
	 */
	public function after_setup_theme() {
		Carbon_Fields::boot();
	}

}
