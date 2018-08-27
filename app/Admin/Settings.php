<?php

namespace Diviner\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\Admin
 */
class Settings {

	const FIELD_GENERAL_PERMISSIONS = 'diviner_field_general_permissions';
	const FIELD_GENERAL_BROWSE_TITLE = 'diviner_field_general_browse_title';
	const FIELD_GENERAL_GOOGLE_ID = 'diviner_field_general_google_id';
	const FIELD_GENERAL_BROWSE_MODAL = 'diviner_field_general_browse_modal';
	const FIELD_GENERAL_HELP_PAGE = 'diviner_field_general_help_page';

	protected $theme_options;

	/**
	 * Setup Basic plugin settings
	 */
	public function crb_attach_theme_options() {
		$this->theme_options = Container::make(
			'theme_options',
			__( 'Diviner Settings', 'crb' )
		)->add_fields(
			array(
				$this->permissions_field(),
				$this->browse_field(),
				$this->browse_modal_field(),
				$this->google_field(),
				$this->help_page_field()
			)
		);

	}

	public function permissions_field() {
		return Field::make( 'rich_text', self::FIELD_GENERAL_PERMISSIONS, 'Permissions/Rights Note on Archive item' );
	}

	public function browse_field() {
		return Field::make( 'text', self::FIELD_GENERAL_BROWSE_TITLE, 'Browse Page Title' )
			->set_help_text( 'Ex: Explore Photos' );
	}

	public function google_field() {
		return Field::make( 'text', self::FIELD_GENERAL_GOOGLE_ID, 'Google Analytics ID' );
	}

	public function browse_modal_field() {
		return Field::make( 'checkbox', self::FIELD_GENERAL_BROWSE_MODAL, 'Activate Modal in browse page on click' )
			->set_help_text( 'Modal displays by default mid size image, title, and copyright information' );
	}

	public function get_pages() {
		$cleaned = [
			0 => ''
		];
		$args = array(
			'post_type'    => 'page',
			'sort_column'  => 'menu_order'
		);
		$pages = get_pages( $args );
		foreach ($pages as $page) {
			$cleaned[$page->ID] = $page->post_title;
		}
		return $cleaned;
	}

	public function help_page_field() {
		return Field::make( 'select', self::FIELD_GENERAL_HELP_PAGE, 'Help Page' )
			->add_options( [ $this, 'get_pages' ] )
			->set_help_text( 'Appears on the browse page in the upper right' );
	}
}
