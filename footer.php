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

use function Diviner_Archive\Helpers\diviner_archive_template;
use \Diviner_Archive\Theme\Diviner_Archive_General;

/**
 * Renders layout's footer.
 *
 * @see resources/templates/layout/footer.tpl.php
 */
diviner_archive_template('layout/footer' );
