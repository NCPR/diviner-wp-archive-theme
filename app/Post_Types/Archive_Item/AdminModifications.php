<?php

namespace Diviner\Post_Types\Archive_Item;

use function Tonik\Theme\App\config;

class AdminModifications {

	const DIV_COL_TYPE = 'div_col_type';

	public function hooks() {
		add_action( 'admin_menu', array( &$this,'register_menu_links') );
		add_filter( 'admin_body_class', array( &$this,'admin_body_class') );
		add_filter( 'manage_edit-diviner_archive_item_columns', [ $this, 'archival_item_columns' ] );
		add_action( 'manage_diviner_archive_item_posts_custom_column', [ $this, 'manage_diviner_archive_item_posts_custom_column' ], 10, 2 );
	}

	function manage_diviner_archive_item_posts_custom_column( $colname, $cptid  ) {
		if ( $colname == self::DIV_COL_TYPE && !empty( $cptid ) ) {
			$type = carbon_get_post_meta( $cptid, Post_Meta::FIELD_TYPE );
			if ( ! empty($type) ){
				echo Post_Meta::get_type_label_from_id($type);
			}
		}
	}

	function archival_item_columns( $columns ) {
		$columns[ self::DIV_COL_TYPE ] = "Type";
		return $columns;
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
