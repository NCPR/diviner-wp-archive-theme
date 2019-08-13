<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner_Archive\Admin\General;
use \Diviner_Archive\Admin\Customizer;
use \Diviner_Archive\Admin\Editor;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ General::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new General();
};
$container[ General::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Customizer::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Customizer();
};
$container[ Customizer::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Editor::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Editor();
};
$container[ Editor::PIMPLE_CONTAINER_NAME ]->hooks();
