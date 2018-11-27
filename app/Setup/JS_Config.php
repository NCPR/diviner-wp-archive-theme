<?php

namespace Diviner\Setup;

class JS_Config {

	private $data;

	public function get_data() {
		if ( !isset( $this->data ) ) {
			$this->data = [
				'base_browse_url' => '/' . basename( get_permalink() ),
			];
			$this->data = apply_filters( 'diviner_js_config', $this->data );
		}

		return $this->data;
	}
}