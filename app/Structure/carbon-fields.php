<?php

use \Pimple\Container;
use \Diviner\CarbonFields\Boot;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'carbonfields.boot' ] = function ( Container $container ) {
	return new Boot();
};
$container[ 'carbonfields.boot' ]->hook();