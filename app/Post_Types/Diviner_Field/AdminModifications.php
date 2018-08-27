<?php

namespace Diviner\Post_Types\Diviner_Field;

use Diviner\Post_Types\Diviner_Field\Preset_Fields_List_Table;
use Diviner\Post_Types\Diviner_Field\Default_Fields_List_Table;

class AdminModifications {

	public function hooks() {
		add_action( 'admin_menu', array( &$this,'rc_scd_register_menu') );
		add_filter( 'admin_body_class', array( &$this,'admin_body_class') );
		add_filter( 'gettext', array( &$this,'change_excerpt_text'), 10, 2 );

	}


	function change_excerpt_text( $translation, $original ){
		global $post;
		if( !empty($post) && $post->post_type !== Diviner_Field::NAME) {
			return $translation;
		}
		if ( 'Excerpt' == $original )
		{
			return 'Description'; //Change here to what you want Excerpt box to be called
		}else
		{
			$pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');

			if ($pos !== false)
			{
				return  'Description for field';
			}
		}
		return $translation;
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

		$classes .= sprintf( ' post-edit--%s', $post->post_type );
		if( $post->post_type == Diviner_Field::NAME && in_array( $pagenow, array( 'post.php',  ) ) ) {
			// get the type of field
			$type = carbon_get_the_post_meta( PostMeta::FIELD_TYPE );
			$classes .= sprintf( ' post-field-type--%s', $type );
		}
		return $classes;
	}

	function rc_scd_redirect_dashboard() {

		if( is_admin() ) {
			$screen = get_current_screen();

			if( $screen->base == 'dashboard' ) {

				wp_redirect( admin_url( 'index.php?page=custom-dashboard' ) );

			}
		}

	}

	function rc_scd_register_menu() {

		add_menu_page( 'Diviner Fields', 'Manage	 Diviner Fields', 'manage_options', 'diviner-manage-fields', array( &$this,'rc_scd_create_dashboard'), 'dashicons-admin-generic', 30 );

	}

	function rc_scd_create_dashboard() {
		?>

		<?php
		/**
		 * Our custom dashboard page
		 */

		/** WordPress Administration Bootstrap */
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>

		<div class="wrap wrap-diviner wrap-diviner--default">
			<?php
			$defaultTable = new Default_Fields_List_Table();
			$defaultTable ->prepare_items();
			?>
			<h2>Default Fields</h2>
			<div class="about-text">
				<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
			</div>
			<div class="wrap">
				<?php $defaultTable ->display(); ?>
			</div>

		</div>

		<div class="wrap wrap-diviner wrap-diviner--preset" id="wrap-diviner--preset">
			<?php
			$presetFieldTable = new Preset_Fields_List_Table();
			$presetFieldTable->prepare_items();
			?>
			<h2>Preset Configurable Fields</h2>
			<div class="about-text">
				<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
			</div>
			<div class="wrap">
				<?php $presetFieldTable->display(); ?>
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Submit Form"></p>

			</div>


		</div>

		<?php
	}

}
