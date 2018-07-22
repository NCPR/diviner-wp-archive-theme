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

		$action = 'after_setup_theme';
		if ( DIVINER_IS_PLUGIN ) {
			$action = 'plugins_loaded';
		}

		add_filter( $action, [ $this, 'boot_carbon_fields' ] );
	}

	/**
	 * Boot carbon fields after theme setup
	 */
	public function boot_carbon_fields() {
		Carbon_Fields::boot();
	}

}
