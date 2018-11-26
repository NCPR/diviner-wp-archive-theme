<?php

namespace Diviner\Post_Types\Archive_Item;

use function Tonik\Theme\App\config;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta as FieldPostMeta;
use Diviner\CarbonFields\Helper;
use Diviner\CarbonFields\Errors\UndefinedType;

class AdminModifications {

	const DIV_COL_TYPE = 'div_col_type';

	public function hooks() {
		add_action( 'admin_menu', [ &$this,'register_menu_links' ] );
		add_filter( 'admin_body_class', [ &$this,'admin_body_class' ] );
		add_filter( 'manage_edit-diviner_archive_item_columns', [ $this, 'archival_item_columns' ] );
		add_action( 'manage_diviner_archive_item_posts_custom_column', [ $this, 'manage_diviner_archive_item_posts_custom_column' ], 10, 2 );
		add_action( 'carbon_fields_register_fields', [ $this, 'active_field_setup' ], 3, 0 );
	}

	function active_field_setup(  ) {
		$meta_query = [
			[
				'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
				'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
			],
		];
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => Diviner_Field::NAME,
			'meta_query' => $meta_query
		];
		$posts_ids = get_posts($args);
		foreach($posts_ids as $post_id) {
			$field_type = carbon_get_post_meta($post_id, FieldPostMeta::FIELD_TYPE, 'carbon_fields_container_field_variables');
			$field = Diviner_Field::get_class($field_type);
			if( is_callable( [ $field, 'setup' ] ) ){
				call_user_func( [ $field, 'setup' ], $post_id);
			}
		}
	}

	function manage_diviner_archive_item_posts_custom_column( $colname, $cptid  ) {
		if ( $colname == static::DIV_COL_TYPE && !empty( $cptid ) ) {
			$type = carbon_get_post_meta( $cptid, Post_Meta::FIELD_TYPE );
			if ( ! empty($type) ){
				echo Post_Meta::get_type_label_from_id($type);
			}
		}
	}

	function archival_item_columns( $columns ) {
		$columns[ static::DIV_COL_TYPE ] = "Type";
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
			return $classes;
		}
		// what type of class is this
		if ( get_post_type() !== Archive_Item::NAME ) {
			return $classes;
		}

		if ( get_the_ID() ) {

		}

		$type = carbon_get_post_meta( get_the_ID(), Post_Meta::FIELD_TYPE );
        $classes .= ' archive-item-edit';
		if ( ! empty( $type ) ) {
			$classes .= sprintf( ' archive-item-edit--%s', $type );
		} else {
			// pseudo code
			// check the query
			if ( !empty( $_GET[ 'type' ] ) ) {
				$type = $_GET[ 'type' ];
				if ( ! empty( $type ) ) {
					// $classes .= sprintf( ' archive-item-edit--%s', $field_type );
				}
			}
		}

		return $classes;
	}

	function register_menu_links() {

		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Photo','ncpr-diviner'),
			__('Add New Photo','ncpr-diviner'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=photo'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Audio','ncpr-diviner'),
			__('Add New Audio','ncpr-diviner'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=audio'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Video','ncpr-diviner'),
			__('Add New Video','ncpr-diviner'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=video'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Document','ncpr-diviner'),
			__('Add New Document','ncpr-diviner'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=document'
		);
		add_submenu_page(
			'edit.php?post_type=diviner_archive_item',
			__('Add New Mixed Media','ncpr-diviner'),
			__('Add New Mixed Media','ncpr-diviner'),
			'manage_options',
			'post-new.php?post_type=diviner_archive_item&type=mixed'
		);

		remove_submenu_page( 'edit.php?post_type=diviner_archive_item', 	'post-new.php?post_type=diviner_archive_item' );
	}

}
