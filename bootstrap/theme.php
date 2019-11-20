<?php

/*
 * Shim for wp_body_open function for backwards compatibility
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


/*
|-----------------------------------------------------------
| Create the Theme
|-----------------------------------------------------------
|
| Create a new Theme instance which behaves as singleton.
| This allows for easily bind and resolve various
| parts across all theme components.
|
*/

/** @var \Tonik\Gin\Foundation\Theme $theme */
$theme = Tonik\Gin\Foundation\Theme::getInstance();


/*
 |-----------------------------------------------------------
 | Bind Theme Config
 |-----------------------------------------------------------
 |
 | We need to bind configs like theme's paths, directories and
 | files to autoload. These values will be used by the rest
 | of theme components like assets, templates etc.
 |
 */

// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
$config = require get_template_directory() . '/config/theme-app.php';

$theme->bind('config', function () use ($config) {
    return new Tonik\Gin\Foundation\Config($config);
});


/*
 |-----------------------------------------------------------
 | Return the Theme
 |-----------------------------------------------------------
 |
 | Here we return the theme instance. Later, this instance
 | is used for autoload all theme's core component.
 |
 */

return $theme;
