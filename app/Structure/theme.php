<?php

namespace Diviner_Archive\Structure;

use \Pimple\Container;
use \Diviner_Archive\Theme\Diviner_Archive_General;
use \Diviner_Archive\Theme\Diviner_Archive_Image;
use \Diviner_Archive\Theme\Diviner_Archive_Search_Page;
use \Diviner_Archive\Theme\Diviner_Archive_Post_Meta;
use \Diviner_Archive\Theme\Diviner_Archive_Widgets;

$container = \Diviner_Archive\Diviner_Archive_Main::instance()->container();

$container[ 'theme.general' ] = function ( Container $container ) {
	return new Diviner_Archive_General();
};
$container[ 'theme.general' ]->hooks();

$container[ 'theme.image' ] = function ( Container $container ) {
	return new Diviner_Archive_Image();
};
$container[ 'theme.image' ]->hooks();

$container[ 'theme.search_page' ] = function ( Container $container ) {
	return new Diviner_Archive_Search_Page();
};
$container[ 'theme.search_page' ]->hooks();

$container[ 'theme.post_meta' ] = function ( Container $container ) {
	return new Diviner_Archive_Post_Meta();
};
$container[ 'theme.post_meta' ]->hooks();

$container[ 'theme.widgets' ] = function ( Container $container ) {
	return new Diviner_Archive_Widgets();
};
$container[ 'theme.widgets' ]->hooks();
