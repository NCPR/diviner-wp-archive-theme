<?php

namespace Diviner\Post_Types\Archive_Item;

use function Tonik\Theme\App\config;

class AdminModifications {

	public function hooks() {
		add_action( 'admin_menu', array( &$this,'register_menu_links') );
		add_filter( 'admin_body_class', array( &$this,'admin_body_class') );
	}

	/**
	 * Adds one or more classes to the body tag in the dashboard.
	 *
	 * @param  String $classes Current body classes.
	 * @return String          Altered body classes.
	 */
	function admin_body_class( $classes ) {
		global $post;
		global $pagenow;

		if (!$pagenow || !$post) {
			return;
		}
		// what type of class is this
		$type = carbon_get_the_post_meta( Post_Meta::FIELD_TYPE );
		$classes .= sprintf( ' archive-item-edit--%s', $type );

		return $classes;
	}

	function register_menu_links() {

		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Photo','menu-test'),
			__('Add New Photo','menu-test'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=photo'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Audio','menu-test'),
			__('Add New Audio','menu-test'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=audio'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Video','menu-test'),
			__('Add New Video','menu-test'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=video'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Document','menu-test'),
			__('Add New Document','menu-test'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=document'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Mixed Media','menu-test'),
			__('Add New Mixed Media','menu-test'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=mixed'
		);

		remove_submenu_page( 'edit.php?post_type=diviner_archive_item', 	'post-new.php?post_type=diviner_archive_item' );

		//add_menu_page( 'Diviner Fields', 'Manage	 Diviner Fields', 'manage_options', 'diviner-manage-fields', array( &$this,'rc_scd_create_dashboard'), 'dashicons-admin-generic', 30 );

	}

}
