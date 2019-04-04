<?php

namespace Tonik\Theme\Footer;

/*
|------------------------------------------------------------------
| Footer Controller
|------------------------------------------------------------------
|
| Controller for outputting layout's closing markup. Template
| rendered here should include `wp_footer()` function call.
|
*/

use function Tonik\Theme\App\template;
use \Diviner\Theme\General;

/**
 * Renders layout's footer.
 *
 * @see resources/templates/layout/footer.tpl.php
 */
template('layout/footer', [
	'footer_menu' => General::the_footer_menu(),
	'footer_social' => General::the_social_module(),
	'footer_copy' => General::the_footer_copy(),
]);
