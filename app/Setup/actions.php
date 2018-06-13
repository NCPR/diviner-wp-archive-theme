<?php

namespace Tonik\Theme\App\Setup;

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
