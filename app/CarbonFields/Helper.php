<?php

namespace Diviner\CarbonFields;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\CarbonFields
 */
class Helper {

	/**
	 * Example
	 */
	static public function get_real_field_name( $name ) {
		return sprintf( '_%s', $name );
	}

}
