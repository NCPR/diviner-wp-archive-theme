<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Admin\Settings;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'admin.settings' ] = function ( Container $container ) {
	return new Settings();
};

add_action( 'carbon_fields_register_fields', function () use ( $container ) {
	$container[ 'admin.settings' ]->crb_attach_theme_options();
}, 0, 0 );
