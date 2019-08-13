<?php

namespace Tonik\Theme\App\Structure;

use \Pimple\Container;
use \Diviner_Archive\Theme\General;
use \Diviner_Archive\Theme\Image;
use \Diviner_Archive\Theme\Search_Page;
use \Diviner_Archive\Theme\Post_Meta;
use \Diviner_Archive\Theme\Widgets;

$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'theme.general' ] = function ( Container $container ) {
	return new General();
};
$container[ 'theme.general' ]->hooks();

$container[ 'theme.image' ] = function ( Container $container ) {
	return new Image();
};
$container[ 'theme.image' ]->hooks();

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
