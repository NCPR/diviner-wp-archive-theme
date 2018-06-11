<?php

namespace Tonik\Theme\App\Setup;

use Pimple\Container;
use Diviner\CarbonFields\Boot;

/*
|-----------------------------------------------------------
| Theme Filters
|-----------------------------------------------------------
|
| This file purpose is to include your theme various
| filters hooks, which changes output or behaviour
| of different parts of WordPress functions.
|
*/

/**
 * Hides sidebar on index template on specific views.
 *
 * @see apply_filters('theme/index/sidebar/visibility')
 * @see apply_filters('theme/single/sidebar/visibility')
 */
function show_index_sidebar($status)
{
    if (is_404() || is_page()) {
        return false;
    }

    return $status;
}
add_filter('theme/index/sidebar/visibility', 'Tonik\Theme\App\Setup\show_index_sidebar');
add_filter('theme/single/sidebar/visibility', 'Tonik\Theme\App\Setup\show_index_sidebar');

/**
 * Shortens posts excerpts to 60 words.
 *
 * @return integer
 */
function modify_excerpt_length()
{
    return 60;
}
add_filter('excerpt_length', 'Tonik\Theme\App\Setup\modify_excerpt_length');


$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'carbonfields.boot' ] = function ( Container $container ) {
	return new Boot();
};

add_action( 'after_setup_theme', function () use ( $container ) {
	$container[ 'carbonfields.boot' ]->after_setup_theme();
}, 10, 0 );
