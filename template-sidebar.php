<?php
/**
 * Template Name: One Column with Sidebar Template
 */
?>
<?php

namespace Diviner_Archive\Theme\Page;

/*
|------------------------------------------------------------------
| Page Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function Diviner_Archive\Helpers\diviner_archive_template;

/**
 * Renders single page.
 *
 * @see resources/templates/single.tpl.php
 */
diviner_archive_template('single');
