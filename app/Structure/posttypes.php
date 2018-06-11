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

use \Diviner\Post_Types\Diviner_Field\Diviner_Field;
use \Diviner\Post_Types\Diviner_Field\PostMeta;


/**
 * Registers `book` custom post type.
 *
 * @return void
 */
function register_book_post_type()
{
    register_post_type('book', [
        'description' => __('Collection of books.', config('textdomain')),
        'public' => true,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'],
        'labels' => [
            'name' => _x('Books', 'post type general name', config('textdomain')),
            'singular_name' => _x('Book', 'post type singular name', config('textdomain')),
            'menu_name' => _x('Books', 'admin menu', config('textdomain')),
            'name_admin_bar' => _x('Book', 'add new on admin bar', config('textdomain')),
            'add_new' => _x('Add New', 'book', config('textdomain')),
            'add_new_item' => __('Add New Book', config('textdomain')),
            'new_item' => __('New Book', config('textdomain')),
            'edit_item' => __('Edit Book', config('textdomain')),
            'view_item' => __('View Book', config('textdomain')),
            'all_items' => __('All Books', config('textdomain')),
            'search_items' => __('Search Books', config('textdomain')),
            'parent_item_colon' => __('Parent Books:', config('textdomain')),
            'not_found' => __('No books found.', config('textdomain')),
            'not_found_in_trash' => __('No books found in Trash.', config('textdomain')),
        ],
    ]);
}
// add_action('init', 'Tonik\Theme\App\Structure\register_book_post_type');


$container = \Tonik\Theme\App\Main::instance()->container();

$container[ 'post_types.archive_item' ] = function ( Container $container ) {
	return new \Diviner\Post_Types\Archive_Item\Archive_Item();
};

add_action( 'init', function() use ( $container ) {
	$container[ 'post_types.archive_item' ]->register();
}, 0, 0 );

$container[ 'post_types.diviner_field.diviner_field' ] = function ( Container $container ) {
	return new Diviner_Field();
};
add_action( 'init', function() use ( $container ) {
	$container[ 'post_types.diviner_field.diviner_field' ]->register();
}, 0, 0 );

$container[ 'post_types.diviner_field.postmeta' ] = function ( Container $container ) {
	return new PostMeta();
};
add_action( 'init', function() use ( $container ) {
	$container[ 'post_types.diviner_field.postmeta' ]->add_post_meta();
}, 0, 0 );

