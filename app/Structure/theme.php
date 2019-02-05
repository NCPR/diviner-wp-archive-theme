<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Theme\General;
use \Diviner\Theme\Image;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'theme.general' ] = function ( Container $container ) {
	return new General();
};
$container[ 'theme.general' ]->hooks();

$container[ 'theme.image' ] = function ( Container $container ) {
	return new Image();
};
$container[ 'theme.image' ]->hooks();
