<?php

namespace Diviner\Theme;

/**
 * Class Settings
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class General {

	public function hooks() {
		add_action( 'wp_head', [$this, 'awesome_fonts'], 0, 0 );
	}

	static public function the_primary_menu() {
		return sprintf(
			'<nav class="primary-menu"><div class="a11y-visual-hide">%s</div>%s</nav>',
			__( 'Primary Navigation', 'ncpr-diviner'),
			wp_nav_menu( [
				'theme_location' => 'primary',
				'echo' => false,
			] )
		);

	}

	static public function the_header_brand() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$brand = '';
		if ( has_custom_logo() ) {
			$brand = sprintf(
				'<h1 class="header__logo"><a href="%s" class="header__logo-link"><img src="%s" title="%s" class="header__logo-img"></a></h1>',
				get_home_url(),
				esc_url( $logo[0] ),
				get_bloginfo( 'name' )
			);
		} else {
			$brand = sprintf(
				'<h1 class="header__title"><a href="%s" class="header__title-link">%s</a></h1>',
				get_home_url(),
				get_bloginfo( 'name' )
			);
		}
		return $brand;
	}

	public function awesome_fonts() {
		?>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/solid.css" integrity="sha384-aj0h5DVQ8jfwc8DA7JiM+Dysv7z+qYrFYZR+Qd/TwnmpDI6UaB3GJRRTdY8jYGS4" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/regular.css" integrity="sha384-l+NpTtA08hNNeMp0aMBg/cqPh507w3OvQSRoGnHcVoDCS9OtgxqgR7u8mLQv8poF" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/fontawesome.css" integrity="sha384-WK8BzK0mpgOdhCxq86nInFqSWLzR5UAsNg0MGX9aDaIIrFWQ38dGdhwnNCAoXFxL" crossorigin="anonymous">
		<?php
	}

}
