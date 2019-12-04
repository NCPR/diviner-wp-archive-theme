<?php

namespace Diviner_Archive\Config;

/**
 * Class General
 *
 * @package Diviner_Archive\Config
 */
class Diviner_Archive_General {

	const VERSION = '0.6';

	const IMAGE_SIZE_BROWSE_POPUP = 'diviner_archive_image_size_browse_popup';
	const IMAGE_SIZE_BROWSE_GRID = 'diviner_archive_image_size_browse_grid';

	const IMAGE_SIZE_FEATURE_SM   = 'diviner_archive_image_size_feature_sm'; // 5 x 1
	const IMAGE_SIZE_FEATURE_MD   = 'diviner_archive_image_size_feature_md';
	const IMAGE_SIZE_FEATURE_LRG  = 'diviner_archive_image_size_feature_lrg';

	const IMAGE_SIZE_THUMBNAIL_LRG = 'diviner_archive_image_size_thumb_lrg';
	const IMAGE_SIZE_THUMBNAIL_SM = 'diviner_archive_image_size_thumb_sm';

	const IMAGE_SIZE_FEATURE_4x3_LRG  = 'diviner_archive_image_size_feature_4x3_lrg'; // 4 x 3
	const IMAGE_SIZE_FEATURE_4x3_MD = 'diviner_archive_image_size_feature_4x3_md';

	const IMAGE_SIZE_CARD_LRG  = 'diviner_archive_image_size_card_lrg'; // 16 x 9
	const IMAGE_SIZE_CARD_MD = 'diviner_archive_image_size_card_md';
	const IMAGE_SIZE_CARD_SM = 'diviner_archive_image_size_card_sm';

	const IMAGE_SIZE_ARCHIVE_SINGLE_LRG  = 'diviner_archive_image_size_archive_single_lrg';
	const IMAGE_SIZE_ARCHIVE_SINGLE_M  = 'diviner_archive_image_size_archive_single_m';
	const IMAGE_SIZE_ARCHIVE_SINGLE_SM  = 'diviner_archive_image_size_archive_single_s';

	// overridden by CSS
	const OEMBED_AUDIO_DIMENSIONS_WIDTH = 700;
	const OEMBED_AUDIO_DIMENSIONS_HEIGHT = 81;

	const FONTS = [
		'Source Sans Pro:400,700,400i'     => 'Source Sans Pro',
		'Open Sans:400i,400,700'           => 'Open Sans',
		'Oswald:400,700'                   => 'Oswald',
		'Playfair Display:400,700,400i'    => 'Playfair Display',
		'Montserrat:400,700'               => 'Montserrat',
		'Raleway:400,700'                  => 'Raleway',
		'Droid Sans:400,700'               => 'Droid Sans',
		'Lato:400,700,400i'                => 'Lato',
		'Arvo:400,700,400i'                => 'Arvo',
		'Lora:400,700,400i'                => 'Lora',
		'Merriweather:400,400i,700'        => 'Merriweather',
		'Oxygen:400,300,700'               => 'Oxygen',
		'PT Serif:400,700'                 => 'PT Serif',
		'PT Sans:400,700,400i'             => 'PT Sans',
		'PT Sans Narrow:400,700'           => 'PT Sans Narrow',
		'Cabin:400,700,400i'               => 'Cabin',
		'Josefin Sans:400,700'             => 'Josefin Sans',
		'Libre Baskerville:400,400i,700'   => 'Libre Baskerville',
		'Arimo:400,700,400i'               => 'Arimo',
		'Ubuntu:400,700,400i'              => 'Ubuntu',
		'Bitter:400,700,400i'              => 'Bitter',
		'Droid Serif:400,700,400i'         => 'Droid Serif',
		'Roboto:400,400i,700'              => 'Roboto',
		'Open Sans Condensed:700,300i,300' => 'Open Sans Condensed',
		'Roboto Condensed:400i,400,700'    => 'Roboto Condensed',
		'Roboto Slab:400,700'              => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700'        => 'Yanone Kaffeesatz',
		'Noto Sans:400,400i,700'           => 'Noto Sans',
		'Work Sans:400,700'                => 'Work Sans',
	];

	static $image_sizes = [
		self::IMAGE_SIZE_BROWSE_POPUP => [
			'width'  => 600,
			'height' => 0,
			'crop'   => true,
		],
		self::IMAGE_SIZE_BROWSE_GRID => [
			'width'  => 600,
			'height' => 600,
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
		self::IMAGE_SIZE_ARCHIVE_SINGLE_LRG => [
			'width'  => 1600,
			'height' => 0,
			'crop'   => false,
		],
		self::IMAGE_SIZE_ARCHIVE_SINGLE_M => [
			'width'  => 1200,
			'height' => 0,
			'crop'   => false,
		],
		self::IMAGE_SIZE_ARCHIVE_SINGLE_SM => [
			'width'  => 800,
			'height' => 0,
			'crop'   => false,
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
