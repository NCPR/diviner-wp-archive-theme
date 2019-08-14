<?php

namespace Diviner_Archive\Theme\Index;

/*
|------------------------------------------------------------------
| Index Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function Diviner_Archive\Helpers\diviner_archive_template;

/**
 * Renders index page.
 *
 * @see resources/templates/partials/comments.tpl.php
 */
diviner_archive_template('partials/comments');