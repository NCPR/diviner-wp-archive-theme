<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Admin\Settings;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'admin.settings' ] = function ( Container $container ) {
	return new Settings();
};

$container[ 'admin.settings' ]->hooks();

