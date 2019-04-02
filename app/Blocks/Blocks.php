<?php

namespace Diviner\Blocks;


/**
 * Blocks stuff
 *
 * @package Diviner\Admin
 */
class Blocks {

	private $_related;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [$this, 'create_blocks'], 0, 0 );
	}

	/**
	 * Custom Blocks
	 */
	public function create_blocks() {
		$this->_related = new Recent_Archive_Items();
		$this->_related->init();
	}

}
