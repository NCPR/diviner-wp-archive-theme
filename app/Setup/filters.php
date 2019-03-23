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


$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'carbonfields.boot' ] = function ( Container $container ) {
	return new Boot();
};
$container[ 'carbonfields.boot' ]->hook();
