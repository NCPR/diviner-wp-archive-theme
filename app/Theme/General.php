<?php

namespace Diviner\Theme;

use function Tonik\Theme\App\template;

use Diviner\Admin\Customizer;
use Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Archive_Item\Theme as ArchiveItemTheme;

/**
 * Class Settings
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class General {

	const FONTS = [
		'Source Sans Pro:400,700,400italic,700italic' => 'Source Sans Pro',
		'Open Sans:400italic,700italic,400,700' => 'Open Sans',
		'Oswald:400,700' => 'Oswald',
		'Playfair Display:400,700,400italic' => 'Playfair Display',
		'Montserrat:400,700' => 'Montserrat',
		'Raleway:400,700' => 'Raleway',
		'Droid Sans:400,700' => 'Droid Sans',
		'Lato:400,700,400italic,700italic' => 'Lato',
		'Arvo:400,700,400italic,700italic' => 'Arvo',
		'Lora:400,700,400italic,700italic' => 'Lora',
		'Merriweather:400,300italic,300,400italic,700,700italic' => 'Merriweather',
		'Oxygen:400,300,700' => 'Oxygen',
		'PT Serif:400,700' => 'PT Serif',
		'PT Sans:400,700,400italic,700italic' => 'PT Sans',
		'PT Sans Narrow:400,700' => 'PT Sans Narrow',
		'Cabin:400,700,400italic' => 'Cabin',
		'Fjalla One:400' => 'Fjalla One',
		'Francois One:400' => 'Francois One',
		'Josefin Sans:400,300,600,700' => 'Josefin Sans',
		'Libre Baskerville:400,400italic,700' => 'Libre Baskerville',
		'Arimo:400,700,400italic,700italic' => 'Arimo',
		'Ubuntu:400,700,400italic,700italic' => 'Ubuntu',
		'Bitter:400,700,400italic' => 'Bitter',
		'Droid Serif:400,700,400italic,700italic' => 'Droid Serif',
		'Roboto:400,400italic,700,700italic' => 'Roboto',
		'Open Sans Condensed:700,300italic,300' => 'Open Sans Condensed',
		'Roboto Condensed:400italic,700italic,400,700' => 'Roboto Condensed',
		'Roboto Slab:400,700' => 'Roboto Slab',
		'Yanone Kaffeesatz:400,700' => 'Yanone Kaffeesatz',
		'Rokkitt:400' => 'Rokkitt',
	];

	const FONTS_DEFAULT_HEADER = 'Fjalla One:400';
	const FONTS_DEFAULT_BODY = 'Source Sans Pro:400,700,400italic,700italic';

	const SIDEBAR_RIGHT_ID = 'sidebar';

	public function hooks() {
		add_action( 'wp_head', [$this, 'awesome_fonts'], 0, 0 );
		add_action( 'wp_enqueue_scripts', [$this, 'google_fonts'], 0, 0 );
		// add_action( 'wp_enqueue_scripts', [$this, 'lazy-load'], 0, 0 );
		add_action( 'theme/header', [$this, 'render_header']);
		add_action( 'theme/header/feature-image', [$this, 'render_header_feature_image']);
		add_action( 'after_setup_theme', [$this, 'after_setup_theme'] );

	}

	/**
	 * Hides sidebar on index template on specific views.
	 *
	 * @see apply_filters('theme/sidebar/visibility')
	 */
	function single_sidebar_visibility($status) {
		return false;
	}

	/**
	 * Wrapper class is the container around the content area. Add sidebar or other decorator as necessary
	 */
	static function get_wrapper_classes() {
		$classes = [ 'wrapper', 'wrapper--staggered' ];
		return implode ( ' ' , $classes );
	}

	/**
	 * After theme set up
	 *
	 * @return void
	 */
	function after_setup_theme() {

		$this->register_navigation_areas();

		// Theme supports wide images, galleries and videos.
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

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

	static function luminance($hexcolor, $percent = 0.1) {
		if ( strlen( $hexcolor ) < 6 ) {
			$hexcolor = $hexcolor[0] . $hexcolor[0] . $hexcolor[1] . $hexcolor[1] . $hexcolor[2] . $hexcolor[2];
		}
		$hexcolor = array_map('hexdec', str_split( str_pad( str_replace('#', '', $hexcolor), 6, '0' ), 2 ) );

		foreach ($hexcolor as $i => $color) {
			$from = $percent < 0 ? 0 : $color;
			$to = $percent < 0 ? $color : 255;
			$pvalue = ceil( ($to - $from) * $percent );
			$hexcolor[$i] = str_pad( dechex($color + $pvalue), 2, '0', STR_PAD_LEFT);
		}

		return '#' . implode($hexcolor);
	}
	/**
	 * Renders feature image subheader .
	 *
	 * @see resources/templates/index.tpl.php
	 */
	function render_header_feature_image() {
		if ( is_single() || is_page() && has_post_thumbnail() ) {
			template('partials/subheader/default', []);
		}
	}

	/**
	 * Renders index page header.
	 *
	 * @see resources/templates/index.tpl.php
	 */
	function render_header() {
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
	function render_footer() {
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
				'<div class="header__logo"><a href="%s" class="header__logo-link"><img src="%s" title="%s" class="header__logo-img"></a></div>',
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


	/**
	 * Renders the social module.
	 * Todo: Consolidate the code to output each social item... get the instance from the container?
	 *
	 * @see resources/templates/index.tpl.php
	 */
	static function the_social_module () {
		$social_facebook = carbon_get_theme_option(\Diviner\Admin\Settings::FIELD_GENERAL_SOCIAL_FACEBOOK);
		$social_instagram = carbon_get_theme_option(\Diviner\Admin\Settings::FIELD_GENERAL_SOCIAL_INSTAGRAM);
		$social_twitter = carbon_get_theme_option(\Diviner\Admin\Settings::FIELD_GENERAL_SOCIAL_TWITTER);


		if ( !empty( $social_facebook ) || !empty( $social_instagram ) || !empty( $social_twitter ) ) {
			$social_links = [];
			if ( !empty( $social_facebook ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-facebook-f"></span></a></li>',
					esc_attr( $social_facebook ),
					__( 'Facebook Link', 'ncpr-diviner' )
				);
			}
			if ( !empty( $social_instagram ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-instagram"></span></a></li>',
					esc_attr( $social_instagram ),
					__( 'Instagram Link', 'ncpr-diviner' )
				);
			}
			if ( !empty( $social_twitter ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-twitter"></span></a></li>',
					esc_attr( $social_twitter ),
					__( 'Twitter Link', 'ncpr-diviner' )
				);
			}
			return sprintf(
				'<ul class="social-links">%s</ul>',
				implode ( '' , $social_links )
			);
		}

		return '';
	}

	static function the_footer_copy () {
		$copy = carbon_get_theme_option(\Diviner\Admin\Settings::FIELD_GENERAL_FOOTER_COPY);
		if ( !empty( $copy ) ) {
			return sprintf(
				'<div class="footer__copy"><p>%s</p></div>',
				$copy
			);
		}
		return '';
	}

	public function google_fonts() {

		$header_font_key = get_theme_mod(Customizer::SECTION_THEME_CONTROL_FONT_HEADER, static::FONTS_DEFAULT_HEADER);
		$body_font_key = get_theme_mod(Customizer::SECTION_THEME_CONTROL_FONT_BODY, static::FONTS_DEFAULT_BODY);

		if( $header_font_key ) {
			wp_enqueue_style( 'linje-headings-fonts', '//fonts.googleapis.com/css?family='. esc_html($header_font_key) );
		} else {
			wp_enqueue_style( 'linje-source-sans', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
		}
		if( $body_font_key ) {
			wp_enqueue_style( 'linje-body-fonts', '//fonts.googleapis.com/css?family='. esc_html($body_font_key) );
		} else {
			wp_enqueue_style( 'linje-source-body', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600');
		}
	}

	/**
	 * Output the single archive meta fields
	 */
	static public function the_archive_single_meta() {
		echo ArchiveItemTheme::render_meta_fields();
	}

	public function awesome_fonts() {
		?>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/solid.css" integrity="sha384-aj0h5DVQ8jfwc8DA7JiM+Dysv7z+qYrFYZR+Qd/TwnmpDI6UaB3GJRRTdY8jYGS4" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/regular.css" integrity="sha384-l+NpTtA08hNNeMp0aMBg/cqPh507w3OvQSRoGnHcVoDCS9OtgxqgR7u8mLQv8poF" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/brands.css" integrity="sha384-1KLgFVb/gHrlDGLFPgMbeedi6tQBLcWvyNUN+YKXbD7ZFbjX6BLpMDf0PJ32XJfX" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/fontawesome.css" integrity="sha384-WK8BzK0mpgOdhCxq86nInFqSWLzR5UAsNg0MGX9aDaIIrFWQ38dGdhwnNCAoXFxL" crossorigin="anonymous">
		<?php
	}

}
