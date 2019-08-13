<?php

namespace Diviner_Archive\Theme\NotFound;

/*
|------------------------------------------------------------------
| 404 Controller
|------------------------------------------------------------------
|
| The template controller for displaying 404 error pages.
| It is displayed when website content was not found.
|
*/

use function Diviner_Archive\Helpers\template;
use \Diviner_Archive\Theme\Diviner_Archive_General;

/**
 * Renders 404 page.
 *
 * @see resources/templates/index.tpl.php
 */
template('404', [
	'widget_area_404' => Diviner_Archive_General::get_404_widget_area()
]);
