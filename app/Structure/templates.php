<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Templates Actions
|-----------------------------------------------------------
|
| This file purpose is to include your templates rendering
| actions hooks, which allows you to render specific
| partials at specific places of your theme.
|
*/

// ToDo pull these template calls into classes

use function Tonik\Theme\App\template;

/**
 * Renders post thumbnail by its formats.
 *
 * @see resources/templates/index.tpl.php
 */
function render_post_thumbnail()
{
    template(['partials/post/thumbnail', get_post_format()]);
}
add_action('theme/index/post/thumbnail', 'Tonik\Theme\App\Structure\render_post_thumbnail');

/**
 * Renders empty post content where there is no posts.
 *
 * @see resources/templates/index.tpl.php
 */
function render_empty_content()
{
    template(['partials/index/content', 'none']);
}
add_action('theme/index/content/none', 'Tonik\Theme\App\Structure\render_empty_content');

/**
 * Renders post contents by its formats.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_content() {
	if (is_page_template('page-search.php')) {
		$type = 'search';
	} else {
		$type = get_post_type();
	}
	$path = sprintf(
		'partials/%s/content',
		$type
	);
	try {
		template([
			$path,
			get_post_format()
		]);
	} catch (\Exception $ex) {
		template([
			'partials/post/content',
			get_post_format()
		]);
	}
}
add_action('theme/single/content', 'Tonik\Theme\App\Structure\render_post_content');

/**
 * Renders sidebar content.
 *
 * @uses resources/templates/partials/sidebar.tpl.php
 * @see resources/templates/index.tpl.php
 * @see resources/templates/single.tpl.php
 */
function render_sidebar()
{
    get_sidebar();
}
add_action('theme/index/sidebar', 'Tonik\Theme\App\Structure\render_sidebar');
add_action('theme/single/sidebar', 'Tonik\Theme\App\Structure\render_sidebar');
