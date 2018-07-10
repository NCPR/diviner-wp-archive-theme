<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Custom Taxonomies
|-----------------------------------------------------------
|
| This file is for registering your theme custom taxonomies.
| Taxonomies help to classify posts and custom post types.
|
*/

use function Tonik\Theme\App\config;

/**
 * Registers `book_genre` custom taxonomy.
 *
 * @return void
 */
function register_book_genre_taxonomy()
{
    register_taxonomy('book_genre', 'book', [
        'rewrite' => [
            'slug' => 'books/genre',
            'with_front' => true,
            'hierarchical' => true,
        ],
        'hierarchical' => true,
        'public' => true,
        'labels' => [
            'name' => _x('Genres', 'taxonomy general name', 'ncpr-diviner'),
            'singular_name' => _x('Genre', 'taxonomy singular name', 'ncpr-diviner'),
            'search_items' => __('Search Genres', 'ncpr-diviner'),
            'all_items' => __('All Genres', 'ncpr-diviner'),
            'parent_item' => __('Parent Genre', 'ncpr-diviner'),
            'parent_item_colon' => __('Parent Genre:', 'ncpr-diviner'),
            'edit_item' => __('Edit Genre', 'ncpr-diviner'),
            'update_item' => __('Update Genre', 'ncpr-diviner'),
            'add_new_item' => __('Add New Genre', 'ncpr-diviner'),
            'new_item_name' => __('New Genre Name', 'ncpr-diviner'),
            'menu_name' => __('Genre', 'ncpr-diviner'),
        ],
    ]);
}
// add_action('init', 'Tonik\Theme\App\Structure\register_book_genre_taxonomy');
