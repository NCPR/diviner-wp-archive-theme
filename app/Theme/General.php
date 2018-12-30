<?php

namespace Diviner\Theme;

use function Tonik\Theme\App\template;


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
		add_action( 'theme/header', [$this, 'render_header']);
		add_action( 'after_setup_theme', [$this, 'register_navigation_areas'] );
	}

	/**
	 * Registers navigation areas.
	 *
	 * @return void
	 */
	function register_navigation_areas() {
		register_nav_menus([
			'primary' => __('Primary', 'ncpr-diviner'),
			'footer'  => __('Footer', 'ncpr-diviner'),
		]);
	}

	/**
	 * Renders index page header.
	 *
	 * @see resources/templates/index.tpl.php
	 */
	function render_header()
	{
		template('partials/header', [
			'brand' => static::the_header_brand(),
			'lead'  => get_bloginfo( 'description' ),
			'primary_menu' => static::the_primary_menu(),
		]);
	}

	/**
	 * Renders index page footer.
	 *
	 * @see resources/templates/index.tpl.php
	 */
	function render_footer()
	{
		template('layout/footer', [
			'footer_menu' => static::the_footer_menu(),
		]);
	}

	static public function the_footer_menu() {
		return sprintf(
			'<div class="footer-menu__wrap"><nav class="footer-menu"><div class="a11y-visual-hide">%s</div>%s</nav></div>',
			__( 'Footer Navigation', 'ncpr-diviner'),
			wp_nav_menu( [
				'theme_location' => 'footer',
				'echo' => false,
				'depth' => 1
			] )
		);
	}

	static public function the_primary_menu() {
		return sprintf(
			'<div class="primary-menu__wrap" data-js="primary-menu__wrap"><nav class="primary-menu"><button class="primary-menu__close" data-js="primary-menu__close"><span class="fas fa-window-close"></span><span class="a11y-visual-hide">%s</span></button><div class="a11y-visual-hide">%s</div>%s</nav></div>',
			__( 'Close Navigation', 'ncpr-diviner'),
			__( 'Primary Navigation', 'ncpr-diviner'),
			wp_nav_menu( [
				'theme_location' => 'primary',
				'echo' => false,
				'depth' => 2
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

	static function the_social_module () {
		return 'social module';
	}

	static function the_footer_copy () {
		$copy = carbon_get_theme_option(\Diviner\Admin\Settings::FIELD_GENERAL_FOOTER_COPY);
		if ( !empty( $copy ) ) {
			return sprintf(
				'<div class="footer__copy">%s</div>',
				$copy
			);
		}
		return '';
	}

	public function awesome_fonts() {
		?>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/solid.css" integrity="sha384-aj0h5DVQ8jfwc8DA7JiM+Dysv7z+qYrFYZR+Qd/TwnmpDI6UaB3GJRRTdY8jYGS4" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/regular.css" integrity="sha384-l+NpTtA08hNNeMp0aMBg/cqPh507w3OvQSRoGnHcVoDCS9OtgxqgR7u8mLQv8poF" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/fontawesome.css" integrity="sha384-WK8BzK0mpgOdhCxq86nInFqSWLzR5UAsNg0MGX9aDaIIrFWQ38dGdhwnNCAoXFxL" crossorigin="anonymous">
		<?php
	}

}
