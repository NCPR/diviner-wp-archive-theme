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

    /**
     * The built instance of the theme options container.
     *
     * @var \Carbon_Fields\Container\Theme_Options_Container
     */
	protected static $theme_options;

	public function hooks() {
		add_action( 'carbon_fields_register_fields', [$this, 'crb_attach_theme_options'], 0, 0 );
		add_filter( 'diviner_js_config', [ $this, 'custom_diviner_js_config' ] );
	}

	public function custom_diviner_js_config( $data  ) {

		$settings = [
			'permission_notice' => carbon_get_theme_option(self::FIELD_GENERAL_PERMISSIONS),
		];
		$data['settings'] = $settings;
		return $data;

	}

    /**
     * Returns the menu slug of the theme options main page.
     *
     * This is the slug that should be used as `parent_slug` to
     * add sub-menus to the main theme options page or to hide it.
     *
     * @since TBD
     *
     * @return string The main theme options page slug.
     */
    public static function menu_slug() {
        return static::$theme_options->get_page_file();
    }

    /**
	 * Setup Basic plugin settings
	 */
	public function crb_attach_theme_options() {
	    // We can save the result of an instance call in a static property as it will be called once per HTTP request.
		static::$theme_options = Container::make(
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
			->set_help_text( __( 'Related Items – add related items if you want to be able to manually connect your items to one another. For example, you might choose to link a sculpture to a series of paintings, or a video of a downtown area to pictures of downtown businesses. You add related items ONCE only, and it will work for your entire collection. ', 'ncpr-diviner' ) );
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
