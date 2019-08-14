<?php

namespace Diviner_Archive\Structure;

/*
|-----------------------------------------------------------
| Custom Thumbnails Sizes
|-----------------------------------------------------------
|
| This file is for registering your custom
| image sizes, for posts thumbnails.
|
*/

use Diviner_Archive\Config\Diviner_Archive_General;

/**
 * Adds new thumbnails image sizes.
 *
 * @return void
 */
function diviner_archive_add_image_sizes()
{
	foreach ( Diviner_Archive_General::$image_sizes as $key => $attributes ) {
		add_image_size( $key, $attributes[ 'width' ], $attributes[ 'height' ], $attributes[ 'crop' ] );
	}

}
add_action('after_setup_theme', 'Diviner_Archive\Structure\diviner_archive_add_image_sizes');
