<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Custom Post Types
|-----------------------------------------------------------
|
| This file is for registering your theme post types.
| Custom post types allow users to easily create
| and manage various types of content.
|
*/

use \Pimple\Container;
use \Diviner\Post_Types\Archive_Item\Archive_Item;
use \Diviner\Post_Types\Archive_Item\Post_Meta;
use \Diviner\Post_Types\Archive_Item\AdminModifications as ArchiveItemAdminModifications;
use \Diviner\Post_Types\Archive_Item\Rest;
use \Diviner\Post_Types\Archive_Item\Theme as ArchiveItemTheme;
use \Diviner\Post_Types\Diviner_Field\Diviner_Field;
use \Diviner\Post_Types\Diviner_Field\PostMeta as DivinerFieldPostMeta;
use \Diviner\Post_Types\Diviner_Field\AdminModifications;


$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'post_types.archive_item' ] = function ( Container $container ) {
	return new Archive_Item();
};
$container[ 'post_types.archive_item' ]->hooks();

$container[ 'post_types.archive_item.postmeta' ] = function ( Container $container ) {
	return new Post_Meta();
};
$container[ 'post_types.archive_item.postmeta' ]->hooks();

$container[ 'post_types.archive_item.admin_modifications' ] = function ( Container $container ) {
	return new ArchiveItemAdminModifications();
};
$container[ 'post_types.archive_item.admin_modifications' ]->hooks();

$container[ 'post_types.archive_item.rest' ] = function ( Container $container ) {
	return new Rest();
};
$container[ 'post_types.archive_item.rest' ]->hooks();

$container[ 'post_types.archive_item.theme' ] = function ( Container $container ) {
	return new ArchiveItemTheme();
};
$container[ 'post_types.archive_item.theme' ]->hooks();

$container[ 'post_types.diviner_field.diviner_field' ] = function ( Container $container ) {
	return new Diviner_Field();
};
$container[ 'post_types.diviner_field.diviner_field' ]->hooks();

$container[ 'post_types.diviner_field.postmeta' ] = function ( Container $container ) {
	return new DivinerFieldPostMeta();
};
$container[ 'post_types.diviner_field.postmeta' ]->hooks();

$container[ 'post_types.diviner_field.admin_modifications' ] = function ( Container $container ) {
	return new AdminModifications();
};
$container[ 'post_types.diviner_field.admin_modifications' ]->hooks();


