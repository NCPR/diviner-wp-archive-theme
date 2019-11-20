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

use function Diviner_Archive\Helpers\diviner_archive_template;
use \Diviner_Archive\Theme\Diviner_Archive_General;

/**
 * Renders 404 page.
 *
 * @see resources/templates/index.tpl.php
 */
diviner_archive_template('404' );
