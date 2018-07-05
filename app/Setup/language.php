<?php

namespace Tonik\Theme\App\Setup;

/**
 * Loads theme textdomain language files.
 *
 * @return void
 */
function load_textdomain() {
	$paths = config('paths');
	$directories = config('directories');

	load_theme_textdomain(config('textdomain'), "{$paths['directory']}/{$directories['languages']}");
}
add_action('after_setup_theme', 'Tonik\Theme\App\Setup\load_textdomain');
