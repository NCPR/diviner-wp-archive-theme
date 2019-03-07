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

	const VERSION = '1.0.0';

	const IMAGE_SIZE_BROWSE_POPUP = 'image_size_browse_popup';
	const IMAGE_SIZE_FEATURE_SM   = 'image_size_feature_sm';
	const IMAGE_SIZE_FEATURE_MD   = 'image_size_feature_md';
	const IMAGE_SIZE_FEATURE_LRG  = 'image_size_feature_lrg';
	const IMAGE_SIZE_FEATURE_4x3_LRG  = 'image_size_feature_4x3_lrg';
	const IMAGE_SIZE_FEATURE_4x3_MD = 'image_size_feature_4x3_md';

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
		],
		self::IMAGE_SIZE_FEATURE_4x3_LRG => [
			'width'  => 1600,
			'height' => 900,
			'crop'   => true,
		],
		self::IMAGE_SIZE_FEATURE_4x3_MD => [
			'width'  => 800,
			'height' => 450,
			'crop'   => true,
		]
	];

}
