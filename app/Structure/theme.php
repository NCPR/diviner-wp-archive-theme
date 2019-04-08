<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner\Theme\General;
use \Diviner\Theme\Image;
use \Diviner\Theme\Browse_Page;
use \Diviner\Theme\Home_Page;
use \Diviner\Theme\Search_Page;
use \Diviner\Theme\Post_Meta;
use \Diviner\Theme\Widgets;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'theme.general' ] = function ( Container $container ) {
	return new General();
};
$container[ 'theme.general' ]->hooks();

$container[ 'theme.image' ] = function ( Container $container ) {
	return new Image();
};
$container[ 'theme.image' ]->hooks();

$container[ 'theme.browse_page' ] = function ( Container $container ) {
	return new Browse_Page();
};
$container[ 'theme.browse_page' ]->hooks();

$container[ 'theme.home_page' ] = function ( Container $container ) {
	return new Home_Page();
};
$container[ 'theme.home_page' ]->hooks();

$container[ 'theme.search_page' ] = function ( Container $container ) {
	return new Search_Page();
};
$container[ 'theme.search_page' ]->hooks();

$container[ 'theme.post_meta' ] = function ( Container $container ) {
	return new Post_Meta();
};
$container[ 'theme.post_meta' ]->hooks();

$container[ 'theme.widgets' ] = function ( Container $container ) {
	return new Widgets();
};
$container[ 'theme.widgets' ]->hooks();
