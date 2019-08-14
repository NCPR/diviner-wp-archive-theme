<?php

namespace Diviner_Archive\Structure;

use \Pimple\Container;
use \Diviner_Archive\Admin\Diviner_Archive_General;
use \Diviner_Archive\Admin\Diviner_Archive_Customizer;
use \Diviner_Archive\Admin\Diviner_Archive_Editor;

$container = \Diviner_Archive\Diviner_Archive_Main::instance()->container();

$container[ Diviner_Archive_General::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Diviner_Archive_General();
};
$container[ Diviner_Archive_General::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Diviner_Archive_Customizer::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Diviner_Archive_Customizer();
};
$container[ Diviner_Archive_Customizer::PIMPLE_CONTAINER_NAME ]->hooks();

$container[ Diviner_Archive_Editor::PIMPLE_CONTAINER_NAME ] = function ( Container $container ) {
	return new Diviner_Archive_Editor();
};
$container[ Diviner_Archive_Editor::PIMPLE_CONTAINER_NAME ]->hooks();
