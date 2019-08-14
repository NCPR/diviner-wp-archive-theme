<?php

/*
 |------------------------------------------------------------------
 | Bootstrap
 |------------------------------------------------------------------
 |
 | This file is responsible for bootstrapping your theme. Autoloads
 | composer packages, checks compatibility and loads theme files.
 | Most likely, you don't need to change anything in this file.
 | Your theme custom logic should be distributed across a
 | separated components in the `/app` directory.
 |
 */


// Require Composer's autoloading file
// if it's present in theme directory.
if ( file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) {
	require $composer;
}

// Now, we can bootstrap our theme.
$theme = require __DIR__ . '/bootstrap/theme.php';

// Autoload theme. Uses localize_template() and
// supports child theme overriding. However,
// they must be under the same dir path.
( new Tonik\Gin\Foundation\Autoloader( $theme->get( 'config' ) ) )->register();