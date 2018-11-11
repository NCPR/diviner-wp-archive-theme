<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Custom Thumbnails Sizes
|-----------------------------------------------------------
|
| This file is for registering your custom
| image sizes, for posts thumbnails.
|
*/

use Diviner\Config\General;

/**
 * Adds new thumbnails image sizes.
 *
 * @return void
 */
function add_image_sizes()
{
    add_image_size('custom-thumbnail', 800, 600, true);

	foreach ( General::$image_sizes as $key => $attributes ) {
		add_image_size( $key, $attributes[ 'width' ], $attributes[ 'height' ], $attributes[ 'crop' ] );
	}

}
add_action('after_setup_theme', 'Tonik\Theme\App\Structure\add_image_sizes');



