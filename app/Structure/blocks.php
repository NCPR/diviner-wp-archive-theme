<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Blocks\Blocks;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'blocks.blocks' ] = function ( Container $container ) {
	return new Blocks();
};
$container[ 'blocks.blocks' ]->hooks();

