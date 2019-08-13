<?php

namespace Diviner_Archive\Theme;

/**
 * Swatches
 *
 * Functions Theme
 *
 * @package Diviner_Archive\Theme
 */
class Diviner_Archive_Swatches {

	/**
	 * Retrieve colors
	 */
	static function get_colors() {
		return [
			[
				'name'  => __( 'White', 'diviner-archive' ),
				'slug'  => 'white',
				'color'	=> '#ffffff'
			],
			[
				'name'  => __( 'Light gray', 'diviner-archive' ),
				'slug'  => 'light-gray',
				'color'	=> '#f5f5f5'
			],
			[
				'name'  => __( 'Medium gray', 'diviner-archive' ),
				'slug'  => 'medium-gray',
				'color' => '#999'
			],
			[
				'name'  => __( 'Dark gray', 'diviner-archive' ),
				'slug'  => 'dark-gray',
				'color' => '#333'
			],
			[
				'name'  => __( 'Black', 'diviner-archive' ),
				'slug'  => 'black',
				'color'	=> '#000000'
			],
			[
				'name'  => __( 'Prussian Blue', 'diviner-archive' ),
				'slug'  => 'prussian-blue',
				'color'	=> '#0D3B66',
			],
			[
				'name'  => __( 'Oasis Beige', 'diviner-archive' ),
				'slug'  => 'oasis-beige',
				'color'	=> '#FAF0CA'
			],
			[
				'name'  => __( 'Oasis', 'diviner-archive' ),
				'slug'  => 'portica-orange',
				'color'	=> '#F4D35E'
			],
			[
				'name'  => __( 'Turquoise', 'diviner-archive' ),
				'slug'  => 'turquoise',
				'color'	=> '#41D3BD'
			],
			[
				'name'  => __( 'Tomato', 'diviner-archive' ),
				'slug'  => 'tomato',
				'color'	=> '#FE5F55'
			]
		];
	}
}
