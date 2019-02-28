<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Admin\Settings;
use \Diviner\Admin\Customizer;
use \Diviner\Admin\Editor;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'admin.settings' ] = function ( Container $container ) {
	return new Settings();
};
$container[ 'admin.settings' ]->hooks();

$container[ 'admin.customizer' ] = function ( Container $container ) {
	return new Customizer();
};
$container[ 'admin.customizer' ]->hooks();

$container[ 'admin.classic_editor' ] = function ( Container $container ) {
	return new Editor();
};
$container[ 'admin.classic_editor' ]->hooks();

