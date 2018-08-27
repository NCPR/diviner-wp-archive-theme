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

use function Tonik\Theme\App\config;
use \Pimple\Container;
use \Diviner\Post_Types\Archive_Item\Archive_Item;
use \Diviner\Post_Types\Archive_Item\Post_Meta;
use \Diviner\Post_Types\Archive_Item\AdminModifications as ArchiveItemAdminModifications;
use \Diviner\Post_Types\Diviner_Field\Diviner_Field;
use \Diviner\Post_Types\Diviner_Field\PostMeta as DivinerFieldPostMeta;
use \Diviner\Post_Types\Diviner_Field\AdminModifications;


$container = \Tonik\Theme\App\Main::instance()->container();



$container[ 'post_types.archive_item' ] = function ( Container $container ) {
	return new Archive_Item();
};

add_action( 'init', function() use ( $container ) {
	$container[ 'post_types.archive_item' ]->register();
}, 0, 0 );


$container[ 'post_types.archive_item.postmeta' ] = function ( Container $container ) {
	return new Post_Meta();
};
// TO DO: bring this into a hooks function
add_action( 'carbon_fields_register_fields', function() use ( $container ) {
	$container[ 'post_types.archive_item.postmeta' ]->add_post_meta();
}, 3, 0 );

$container[ 'post_types.archive_item.admin_modifications' ] = function ( Container $container ) {
	return new ArchiveItemAdminModifications();
};
$container[ 'post_types.archive_item.admin_modifications' ]->hooks();

$container[ 'post_types.diviner_field.diviner_field' ] = function ( Container $container ) {
	return new Diviner_Field();
};
// TO DO: bring this into a hooks function
add_action( 'init', function() use ( $container ) {
	$container[ 'post_types.diviner_field.diviner_field' ]->register();
}, 0, 0 );

$container[ 'post_types.diviner_field.postmeta' ] = function ( Container $container ) {
	return new DivinerFieldPostMeta();
};
// TO DO: bring this into a hooks function
add_action( 'carbon_fields_register_fields', function() use ( $container ) {
	$container[ 'post_types.diviner_field.postmeta' ]->add_post_meta();
}, 2, 0 );

$container[ 'post_types.diviner_field.admin_modifications' ] = function ( Container $container ) {
	return new AdminModifications();
};
// TO DO: bring this into a hooks function
$container[ 'post_types.diviner_field.admin_modifications' ]->hooks();


