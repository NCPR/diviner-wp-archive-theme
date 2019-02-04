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
	const IMAGE_SIZE_FEATURE_SM   = 'image_size_feature_sm';
	const IMAGE_SIZE_FEATURE_MD   = 'image_size_feature_md';
	const IMAGE_SIZE_FEATURE_LRG  = 'image_size_feature_lrg';

	static $image_sizes = [
		self::IMAGE_SIZE_BROWSE_POPUP => [
			'width'  => 600,
			'height' => 0,
			'crop'   => true,
		],
		self::IMAGE_SIZE_FEATURE_LRG => [
			'width'  => 2000,
			'height' => 400,
			'crop'   => true,
		],
		self::IMAGE_SIZE_FEATURE_MD => [
			'width'  => 1200,
			'height' => 240,
			'crop'   => true,
		],
		self::IMAGE_SIZE_FEATURE_SM => [
			'width'  => 800,
			'height' => 160,
			'crop'   => true,
		]
	];

}
