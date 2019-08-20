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

use function Diviner_Archive\Helpers\diviner_archive_template;

/**
 * Renders empty post content where there is no posts.
 *
 * @see resources/templates/index.tpl.php
 */
function diviner_archive_render_empty_content()
{
    diviner_archive_template(['partials/index/content', 'none']);
}
add_action('theme/index/content/none', 'Diviner_Archive\Structure\diviner_archive_render_empty_content');

/**
 * Renders post contents by its formats.
 *
 * @see resources/templates/single.tpl.php
 */
function diviner_archive_render_post_content() {
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
		diviner_archive_template([
			$path,
			get_post_format()
		]);
	} catch (\Exception $ex) {
		diviner_archive_template([
			'partials/post/content',
			[]
		]);
	}
}
add_action('theme/single/content', 'Diviner_Archive\Structure\diviner_archive_render_post_content');

/**
 * Renders sidebar content.
 *
 * @uses resources/templates/partials/sidebar.tpl.php
 * @see resources/templates/index.tpl.php
 * @see resources/templates/single.tpl.php
 */
function diviner_archive_render_sidebar()
{
    get_sidebar();
}
add_action('theme/index/sidebar', 'Diviner_Archive\Structure\diviner_archive_render_sidebar');
add_action('theme/single/sidebar', 'Diviner_Archive\Structure\diviner_archive_render_sidebar');
