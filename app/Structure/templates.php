<?php

namespace Diviner_Archive\Structure;

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

use function Diviner_Archive\Helpers\template;

/**
 * Renders empty post content where there is no posts.
 *
 * @see resources/templates/index.tpl.php
 */
function render_empty_content()
{
    template(['partials/index/content', 'none']);
}
add_action('theme/index/content/none', 'Diviner_Archive\Structure\render_empty_content');

/**
 * Renders post contents by its formats.
 *
 * @see resources/templates/single.tpl.php
 */
function render_post_content() {
	if (is_page_template('template-search.php')) {
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
add_action('theme/single/content', 'Diviner_Archive\Structure\render_post_content');

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
add_action('theme/index/sidebar', 'Diviner_Archive\Structure\render_sidebar');
add_action('theme/single/sidebar', 'Diviner_Archive\Structure\render_sidebar');
