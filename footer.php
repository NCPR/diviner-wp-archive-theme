<?php

namespace Diviner_Archive\Theme\Footer;

/*
|------------------------------------------------------------------
| Footer Controller
|------------------------------------------------------------------
|
| Controller for outputting layout's closing markup. Template
| rendered here should include `wp_footer()` function call.
|
*/

use function Diviner_Archive\Helpers\template;
use \Diviner_Archive\Theme\Diviner_Archive_General;

/**
 * Renders layout's footer.
 *
 * @see resources/templates/layout/footer.tpl.php
 */
template('layout/footer', [
	'footer_menu' => Diviner_Archive_General::get_footer_menu(),
	'footer_widget_area_1' => Diviner_Archive_General::get_footer_widget_area_1(),
	'footer_widget_area_2' => Diviner_Archive_General::get_footer_widget_area_2(),
]);
