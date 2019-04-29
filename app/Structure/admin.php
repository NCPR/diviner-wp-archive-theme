<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Admin\General;
use \Diviner\Admin\Settings;
use \Diviner\Admin\Customizer;
use \Diviner\Admin\Editor;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ General::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new General();
};
$container[ General::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Settings::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Settings();
};
$container[ Settings::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Customizer::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Customizer();
};
$container[ Customizer::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Editor::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Editor();
};
$container[ Editor::PIMPLE_CONTAINER_NAME ]->hooks();
