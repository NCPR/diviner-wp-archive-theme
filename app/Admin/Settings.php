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
	const FIELD_GENERAL_RELATED_FIELD = 'diviner_field_general_related';

	protected $theme_options;

	/**
	 * Setup Basic plugin settings
	 */
	public function crb_attach_theme_options() {
		$this->theme_options = Container::make(
			'theme_options',
			__( 'Diviner Settings', 'ncpr-diviner' )
		)->add_fields(
			array(
				$this->permissions_field(),
				$this->browse_field(),
				$this->browse_modal_field(),
				$this->google_field(),
				$this->help_page_field(),
				$this->related_field(),
			)
		);

	}

	public function permissions_field() {
		return Field::make( 'rich_text', self::FIELD_GENERAL_PERMISSIONS, __( 'Permissions/Rights Note on Archive item', 'ncpr-diviner' ) );
	}

	public function browse_field() {
		return Field::make( 'text', self::FIELD_GENERAL_BROWSE_TITLE, __( 'Browse Page Title', 'ncpr-diviner' ) )
			->set_help_text( __( 'Ex: Explore Photos','ncpr-diviner' ) );
	}

	public function google_field() {
		return Field::make( 'text', self::FIELD_GENERAL_GOOGLE_ID, __( 'Google Analytics ID', 'ncpr-diviner' ) );
	}

	public function browse_modal_field() {
		return Field::make( 'checkbox', self::FIELD_GENERAL_BROWSE_MODAL, __( 'Activate Modal in browse page on click', 'ncpr-diviner' ) )
			->set_help_text( __( 'Modal displays by default mid size image, title, and copyright information', 'ncpr-diviner' ) );
	}

	public function related_field() {
		return Field::make( 'checkbox', self::FIELD_GENERAL_RELATED_FIELD, __( 'Activate Related Items Field on Archive Items', 'ncpr-diviner' ) )
			->set_help_text( __( 'Allows you to manually associate archive items to each other', 'ncpr-diviner' ) );
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
		return Field::make( 'select', self::FIELD_GENERAL_HELP_PAGE, __( 'Help Page', 'ncpr-diviner' ) )
			->add_options( [ $this, 'get_pages' ] )
			->set_help_text( __( 'Appears on the browse page in the upper right', 'ncpr-diviner' ) );
	}
}
