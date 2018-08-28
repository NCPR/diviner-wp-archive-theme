<?php

namespace Diviner\Post_Types\Diviner_Field;

use Diviner\Post_Types\Diviner_Field\Preset_Fields_List_Table;
use Diviner\Post_Types\Diviner_Field\Default_Fields_List_Table;

use Diviner\Post_Types\Diviner_Field\Types\CPT_Field;
use Diviner\Post_Types\Diviner_Field\Types\Date_Field;
use Diviner\Post_Types\Diviner_Field\Types\Related_Field;
use Diviner\Post_Types\Diviner_Field\Types\Select_Field;
use Diviner\Post_Types\Diviner_Field\Types\Text_Field;
use Diviner\Post_Types\Diviner_Field\Types\Taxonomy_Field;

class AdminModifications {

	const SLUG_WIZARD = 'diviner_wizard';

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
			return $classes;
		}

		if ( get_post_type() !== Diviner_Field::NAME ) {
			return $classes;
		}

		$classes .= sprintf( ' post-edit--%s', $post->post_type );
		if( $post->post_type == Diviner_Field::NAME && in_array( $pagenow, array( 'post.php',  ) ) ) {
			// get the type of field
			// $type = carbon_get_the_post_meta( PostMeta::FIELD_TYPE );
			$type = carbon_get_post_meta( get_the_ID(), PostMeta::FIELD_TYPE );
			$classes .= sprintf( ' post-field-type--%s', $type );
		} else {
			// post-field-type--diviner_date_field
			if ( !empty( $_GET[ 'field_type' ] ) ) {
				$classes .= sprintf( ' post-field-type--%s', $_GET[ 'field_type' ] );
			}
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

		add_submenu_page(
			null,           // -> Set to null - will hide menu link
			'Page Title',    // -> Page Title
			'Menu Title',   // -> Title that would otherwise appear in the menu
			'administrator', // -> Capability level
			self::SLUG_WIZARD,   // -> Still accessible via admin.php?page=menu_handle
			array( &$this,'rc_scd_create_wizard') // -> To render the page
		);

	}

	function rc_scd_create_wizard() {
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

		<div class="wrap wrap-diviner wrap-diviner--limited wrap-diviner--default">

			<h2>Select a Field Type</h2>

			<p>
				<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
			</p>


			<div class="field-select-wrap">
				<h2>Text Field</h2>
				<p>
					<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
				</p>
				<a href="post-new.php?post_type=diviner_field&field_type=<?php echo CPT_Field::NAME; ?>" class="button button-primary button-hero">
					Add a New Text Field
				</a>
			</div>


			<div class="field-select-wrap">
				<h2>Date Field</h2>
				<p>
					<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
				</p>
				<a href="post-new.php?post_type=diviner_field&field_type=<?php echo Date_Field::NAME; ?>" class="button button-primary button-hero">
					Add a New Date Field
				</a>
			</div>

			<div class="field-select-wrap">
				<h2>Taxonomy Field</h2>
				<p>
					<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
				</p>
				<a href="post-new.php?post_type=diviner_field&field_type=<?php echo Taxonomy_Field::NAME; ?>" class="button button-primary button-hero">
					Add a New Taxonomy Field
				</a>
			</div>

			<div class="field-select-wrap">
				<h2>Custom Post Type Field</h2>
				<p>
					<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
				</p>
				<a href="post-new.php?post_type=diviner_field&field_type=<?php echo CPT_Field::NAME; ?>" class="button button-primary button-hero">
					Add a New Custom Post Type Field
				</a>
			</div>

			<div class="field-select-wrap">
				<h2>Select Field</h2>
				<p>
					<?php _e('Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.' ); ?>
				</p>
				<a href="post-new.php?post_type=diviner_field&field_type=select" class="button button-primary button-hero">
					Add a New Select Field
				</a>
			</div>


		</div>




		<?php
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
				<?php _e('These fields are always preset on all archive items. They are part of the standard wordpress experience.' ); ?>
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
				<?php _e('These fields may be activated or deactivated to add meta data and search facets to the base archive item. ' ); ?>
			</div>
			<div>
				<?php $presetFieldTable->display(); ?>
				<input type="submit" name="submit" id="submit" class="button" value="Toggle Field Activattion">
			</div>

		</div>


		<div class="wrap wrap-diviner wrap-diviner--light">

			<h3>
				<?php _e('Click the below button to add more fields.' ); ?>
			</h3>

			<a href="index.php?page=<?php echo self::SLUG_WIZARD; ?>" class="button button-primary button-hero">
				Add a New Field
			</a>


		</div>







		<?php
	}

}
