<?php

namespace Diviner\Blocks;


/**
 * Blocks stuff
 *
 * @package Diviner\Admin
 */
class Blocks {

	private $_related;
	private $_feature_post;
	private $_call_to_action;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [$this, 'create_blocks'], 0, 0 );
		add_filter( 'render_block', [ $this, 'render_blocks_adjustments' ], 10, 2 );
	}

	/**
	 * Render block adjustment. Remove unnecessary wpautop filtering for carbon fields blocks
	 *
	 * https://wordpress.stackexchange.com/questions/321662/how-do-i-disable-wpautop-for-a-specific-block
	 *
	 */
	public function render_blocks_adjustments( $block_content, $block ) {
		if ( preg_match('/carbon-fields/', $block['blockName'] ) ) {
			remove_filter( 'the_content', 'wpautop' );
		}
		return $block_content;
	}

	/**
	 * Custom Blocks
	 */
	public function create_blocks() {
		$this->_related = new Recent_Archive_Items();
		$this->_feature_post = new Feature_Post();
		$this->_call_to_action= new Call_To_Action();
	}

}
