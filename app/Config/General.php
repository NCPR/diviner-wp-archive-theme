<?php

namespace Diviner\Config;

use \Carbon_Fields\Carbon_Fields;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\CarbonFields
 */
class General {

	const IMAGE_SIZE_BROWSE_POPUP = 'image_size_browse_popup';

	static $image_sizes = [
		self::IMAGE_SIZE_BROWSE_POPUP => [
			'width'  => 600,
			'height' => 0,
			'crop'   => true,
		],
	];

}
