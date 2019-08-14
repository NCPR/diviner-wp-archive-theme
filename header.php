<?php

namespace Diviner_Archive\Theme\Header;

/*
|------------------------------------------------------------------
| Header Controller
|------------------------------------------------------------------
|
| Controller for outputting layout's opening markup. Template
| rendered here should include `wp_head()` function call.
|
*/

use function Diviner_Archive\Helpers\diviner_archive_template;

/**
 * Renders layout's head.
 *
 * @see resources/templates/layout/head.tpl.php
 */
diviner_archive_template('layout/head');
