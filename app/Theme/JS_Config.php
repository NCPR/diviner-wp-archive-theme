<?php

namespace Diviner\Theme;

/**
 * JS Config
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class JS_Config {

	private $data;

	public function get_data() {
		if ( !isset( $this->data ) ) {
			$this->data = apply_filters( 'diviner_js_config', $this->data );
		}

		return $this->data;
	}
}