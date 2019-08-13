<?php

namespace Tonik\Theme\NotFound;

/*
|------------------------------------------------------------------
| 404 Controller
|------------------------------------------------------------------
|
| The template controller for displaying 404 error pages.
| It is displayed when website content was not found.
|
*/

use function Tonik\Theme\App\template;
use \Diviner\Theme\General;

/**
 * Renders 404 page.
 *
 * @see resources/templates/index.tpl.php
 */
template('404', [
	'widget_area_404' => General::get_404_widget_area()
]);
