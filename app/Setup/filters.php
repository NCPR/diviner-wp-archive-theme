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
$container[ 'carbonfields.boot' ]->hook();
