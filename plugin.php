<?php
/*
Plugin Name: Diviner WP Archive Plugin
Plugin URI: http://ncpr.org
Description: Plugin for the Diviner Archive ecosystem
Version: 1.0
Author: NCPR
Author URI: http://ncpr.org
Text Domain: ncpr-diviner
Domain Path: resources/languages
License: GPLv2 License
License URI: https://wordpress.org/about/gpl/
*/

/**
 * This is the plugin entry point, if we are here then Diviner
 * is being used as a plugin.
 */
define( 'DIVINER_IS_PLUGIN', true );
define( 'DIVINER_IS_THEME', false );

// Require Composer's autoloading file
// if it's present in theme directory.
if ( file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) {
	require $composer;
}

// Before running we need to check if everything is in place.
// If something went wrong, we will display friendly alert.
$ok = require __DIR__ . '/bootstrap/compatibility.php';

if ( $ok ) {
	// Now, we can bootstrap our plugin.

	/** @var Diviner\Plugin\Plugin $plugin */
	$plugin = require __DIR__ . '/bootstrap/plugin.php';

	// Autoload plugin.
	( new Diviner\Plugin\Autoloader( $plugin->get( 'config' ) ) )->register();
}

