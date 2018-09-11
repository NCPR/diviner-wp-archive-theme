<?php

namespace Tonik\Theme\App\Setup;

use Diviner\Setup\JS_Config;

/*
|-----------------------------------------------------------
| Theme Actions
|-----------------------------------------------------------
|
| This file purpose is to include your custom
| actions hooks, which process a various
| logic at specific parts of WordPress.
|
*/

/**
 * Example action handler.
 *
 * @return integer
 */
function example_action()
{
    //
}
add_filter('excerpt_length', 'Tonik\Theme\App\Setup\example_action');

// Update CSS within in Admin
function diviner_admin_style() {

	wp_register_style( 'admin-styles', get_template_directory_uri().'/public/css/admin.css', false, '1.0.0' );
	wp_enqueue_style( 'admin-styles' );

	// wp_enqueue_style('admin-styles', get_template_directory_uri().'/public/css/admin.css');
}
add_action('admin_enqueue_scripts', 'Tonik\Theme\App\Setup\diviner_admin_style');


function diviner_scripts() {
	$version = date( 'Y.m.d' );

	$app_scripts    = 'browse-app/dist/master.js';
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
		$app_scripts = apply_filters( 'browse_js_dev_path', $app_scripts );
	}
	wp_register_script( 'core-app-browse', $app_scripts );

	$js_config = new JS_Config();
	wp_localize_script( 'core-app-browse', 'diviner_config', $js_config->get_data() );

	wp_enqueue_script( 'core-app-browse', $app_scripts, [  ], $version, true );

}
add_action('wp_enqueue_scripts', 'Tonik\Theme\App\Setup\diviner_scripts');



