<?php

namespace Diviner\Config;

/**
 * Class General
 *
 * @package Diviner\CarbonFields
 */
class General {

	const VERSION = '1.0.0';

	const IMAGE_SIZE_BROWSE_POPUP = 'image_size_browse_popup';

	const IMAGE_SIZE_FEATURE_SM   = 'image_size_feature_sm'; // 5 x 1
	const IMAGE_SIZE_FEATURE_MD   = 'image_size_feature_md';
	const IMAGE_SIZE_FEATURE_LRG  = 'image_size_feature_lrg';

	const IMAGE_SIZE_THUMBNAIL_LRG = 'image_size_thumb_lrg';
	const IMAGE_SIZE_THUMBNAIL_SM = 'image_size_thumb_sm';

	const IMAGE_SIZE_FEATURE_4x3_LRG  = 'image_size_feature_4x3_lrg'; // 4 x 3
	const IMAGE_SIZE_FEATURE_4x3_MD = 'image_size_feature_4x3_md';

	const IMAGE_SIZE_CARD_LRG  = 'image_size_card_lrg'; // 16 x 9
	const IMAGE_SIZE_CARD_MD = 'image_size_card_md';
	const IMAGE_SIZE_CARD_SM = 'image_size_card_sm';

	// overridden by CSS
	const OEMBED_AUDIO_DIMENSIONS_WIDTH = 700;
	const OEMBED_AUDIO_DIMENSIONS_HEIGHT = 81;

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

		self::IMAGE_SIZE_THUMBNAIL_LRG => [
			'width'  => 1200,
			'height' => 900,
			'crop'   => true,
		],
		self::IMAGE_SIZE_THUMBNAIL_SM => [
			'width'  => 800,
			'height' => 600,
			'crop'   => true,
		],

		self::IMAGE_SIZE_FEATURE_4x3_LRG => [
			'width'  => 1600,
			'height' => 1200,
			'crop'   => true,
		],
		self::IMAGE_SIZE_FEATURE_4x3_MD => [
			'width'  => 800,
			'height' => 600,
			'crop'   => true,
		],
		self::IMAGE_SIZE_CARD_LRG => [
			'width'  => 1600,
			'height' => 900,
			'crop'   => true,
		],
		self::IMAGE_SIZE_CARD_MD => [
			'width'  => 1200,
			'height' => 675,
			'crop'   => true,
		],
		self::IMAGE_SIZE_CARD_SM => [
			'width'  => 600,
			'height' => 337,
			'crop'   => true,
		]
	];

}
