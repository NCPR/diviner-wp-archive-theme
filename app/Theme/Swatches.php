<?php

namespace Diviner\Theme;

/**
 * Swatches
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class Swatches {

	/**
	 * Retrieve colors
	 */
	static function get_colors() {
		return [
			[
				'name'  => __( 'White', 'ncpr-diviner' ),
				'slug'  => 'white',
				'color'	=> '#ffffff'
			],
			[
				'name'  => __( 'Light gray', 'ncpr-diviner' ),
				'slug'  => 'light-gray',
				'color'	=> '#f5f5f5'
			],
			[
				'name'  => __( 'Medium gray', 'ncpr-diviner' ),
				'slug'  => 'medium-gray',
				'color' => '#999'
			],
			[
				'name'  => __( 'Dark gray', 'ncpr-diviner' ),
				'slug'  => 'dark-gray',
				'color' => '#333'
			],
			[
				'name'  => __( 'Black', 'ncpr-diviner' ),
				'slug'  => 'black',
				'color'	=> '#000000'
			],
			[
				'name'  => __( 'Prussian Blue', 'ncpr-diviner' ),
				'slug'  => 'prussian-blue',
				'color'	=> '#0D3B66',
			],
			[
				'name'  => __( 'Oasis Beige', 'ncpr-diviner' ),
				'slug'  => 'oasis-beige',
				'color'	=> '#FAF0CA'
			],
			[
				'name'  => __( 'Oasis', 'ncpr-diviner' ),
				'slug'  => 'portica-orange',
				'color'	=> '#F4D35E'
			],
			[
				'name'  => __( 'Turquoise', 'ncpr-diviner' ),
				'slug'  => 'turquoise',
				'color'	=> '#41D3BD'
			],
			[
				'name'  => __( 'Tomato', 'ncpr-diviner' ),
				'slug'  => 'tomato',
				'color'	=> '#FE5F55'
			]
		];
	}
}
