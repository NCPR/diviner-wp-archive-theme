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
	'footer_menu' => General::get_footer_menu(),
	'footer_widget_area_1' => General::get_footer_widget_area_1(),
	'footer_widget_area_2' => General::get_footer_widget_area_2(),
]);
