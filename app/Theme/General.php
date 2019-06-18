<?php

namespace Diviner\Theme;

use function Tonik\Theme\App\template;
use function Tonik\Theme\App\asset_path;

use Diviner\Admin\Customizer;
use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Config\General as GeneralConfig;
use Diviner\Theme\Swatches;

/**
 * Class General
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class General {

	const FONTS_DEFAULT_HEADER = 'Oswald:400,700';
	const FONTS_DEFAULT_BODY = 'Source Sans Pro:400,700,400i';

	public function hooks() {
		add_action( 'wp_head', [ $this, 'awesome_fonts' ], 0, 0 );
		add_action( 'wp_enqueue_scripts', [ $this, 'google_fonts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'output_color_swatch_styles' ] );
		add_action( 'enqueue_block_assets', [ $this, 'block_editor_assets' ] );
		add_filter( 'wp_resource_hints', [ $this, 'resource_hints' ], 10, 2 );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_stylesheets' ] );
		add_action( 'wp_default_scripts', [ $this, 'move_jquery_to_the_footer' ] );
		add_filter( 'excerpt_length', [ $this, 'custom_excerpt_length' ] );
		add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );

		add_action( 'theme/header', [ $this, 'render_header' ] );
		add_action( 'theme/header/feature-image', [ $this, 'render_header_feature_image' ] );
		add_action( 'theme/index/content', [ $this, 'theme_index_content' ] );
		add_action( 'theme/before-content', [$this, 'before_content']);
		add_action( 'theme/article-end', [ $this, 'theme_comments' ], 7 );
		add_action( 'theme/article-end', [ $this, 'page_links' ], 4 );
		add_action( 'theme/article-end', [ $this, 'post_navigation' ], 5 );

	}

	/**
	 * Add image sizes
	 *
	 * @return void
	 */
	function add_image_sizes()
	{
		foreach ( GeneralConfig::$image_sizes as $key => $attributes ) {
			add_image_size( $key, $attributes[ 'width' ], $attributes[ 'height' ], $attributes[ 'crop' ] );
		}

	}

	/**
	 * Display page navigation (next and previous)
	 *
	 * @return void
	 */
	function post_navigation() {
		if ( !is_single() || is_singular( Archive_Item::NAME ) ) {
			return;
		}
		$prev = get_previous_post_link(
				'%link',
			sprintf(
					'<span class="fa fa-arrow-left" aria-hidden="true"></span> %s',
				'%title'
			)
		);

		$next = get_next_post_link(
			'%link',
			sprintf(
				'%s <span class="fa fa-arrow-right" aria-hidden="true"></span>',
				'%title'
			)
		);

		if ( empty( $prev ) && empty( $next ) ) {
			return;
		}
		?>
		<div class="single-item__navigation">
			<div class="a11y-visual-hide">
				<?php echo __( 'Article Navigation', 'diviner-archive' ); ?>
			</div>
			<?php if ( !empty( $prev ) ) { ?>
				<div class="single-item__navigation-btn single-item__navigation-btn--prev">
					<?php echo $prev; ?>
				</div>
			<?php } ?>
			<?php if ( !empty( $next ) ) { ?>
				<div class="single-item__navigation-btn single-item__navigation-btn--next">
					<?php echo $next; ?>
				</div>
			<?php } ?>
		</div> <!-- end navigation -->
		<?php
	}

	/**
	 * Display page links
	 *
	 * @return void
	 */
	function page_links() {
		if ( get_post_type() === 'post' ) {
			echo wp_link_pages( [
				'before'      => '<div class="page-links"><span class="h5 page-links-title">' . __( 'Pages:', 'diviner-archive' ) . '</span>',
				'after'       => '</div>',
				'next_or_number' => 'next',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			] );
		}
	}

	/**
	 * Display comments if necessary
	 *
	 * @return void
	 */
	function theme_comments() {
		if ( comments_open() || get_comments_number() > 0 ) {
			comments_template();
		}
	}

	/**
	 * Display edit links
	 *
	 * @return void
	 */
	function before_content() {
		edit_post_link( __( 'Edit This Content', 'diviner-archive' ), '<div class="edit-link">', '</div>');
	}

	/**
	 * Moves front-end jQuery script to the footer.
	 *
	 * @param  \WP_Scripts $wp_scripts
	 * @return void
	 */
	function move_jquery_to_the_footer($wp_scripts) {
		if (! is_admin()) {
			$wp_scripts->add_data('jquery', 'group', 1);
			$wp_scripts->add_data('jquery-core', 'group', 1);
			$wp_scripts->add_data('jquery-migrate', 'group', 1);
		}
	}

	/**
	 * Get Font Value
	 *
	 * @param  string $key
	 * @return string
	 */
	static public function get_font_value_from_key( $key ) {
		if ( array_key_exists( $key, GeneralConfig::FONTS ) ) {
			return GeneralConfig::FONTS[$key];
		}
		return GeneralConfig::FONTS[static::FONTS_DEFAULT_BODY];
	}

	/**
	 * Registers theme stylesheet files.
	 *
	 * @return void
	 */
	function register_stylesheets() {
		wp_enqueue_style('app', asset_path('css/app.css'));
	}

	/**
	 * Registers theme script files.
	 *
	 * @return void
	 */
	function register_scripts() {
		$version = static::version();
		wp_enqueue_script('vendor', asset_path('js/vendor.js'), [], $version, false);
		wp_enqueue_script('app', asset_path('js/app.js'), ['jquery'], $version, true);
	}

	/**
	 * Filter except length to 35 words.
	 *
	 * @param int $length
	 * @return int
	 */
	function custom_excerpt_length( $length ) {
		return 20;
	}

	/**
	 * Include block editor assets
	 *
	 */
	function block_editor_assets() {
		$this->google_fonts();
		$this->output_color_swatch_styles();
	}

	/**
	 * Add preconnect for Google Fonts.
	 *
	 * @param  array         $urls           URLs to print for resource hints.
	 * @param  string|string $relation_type  The relation type the URLs are printed.
	 * @return array         $urls           URLs to print for resource hints.
	 */
	function resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}
		return $urls;
	}

	/**
	 * Output dynamic color swatches
	 *
	 * @return string   Style tags for block bg colors
	 */
	function get_color_swatch_styles() {
		$styles_background = array_map( function( $color ) {
			return sprintf(
				'.has-%s-background-color { background-color: %s !important; }',
				$color['slug'],
				$color['color']
			);
		},Swatches::get_colors());

		$styles_text = array_map( function( $color ) {
			return sprintf(
				'.has-%s-color, .has-%s-color p { color: %s !important; }',
				$color['slug'],
				$color['slug'],
				$color['color']
			);
		},Swatches::get_colors());

		$style_tag = sprintf(
			'<style type="text/css">%s%s</style>',
			implode("", $styles_background),
			implode("", $styles_text)
		);
		return $style_tag;
	}

	function output_color_swatch_styles() {
		echo $this->get_color_swatch_styles();
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
	 * Get Loop classes
	 */
	static function get_loop_classes() {
		$classes = [
			'loop',
			sprintf(
				'loop--%s',
				get_post_type()
			)
		];
		if ( static::should_display_cards() ) {
			$classes[] = 'loop--cards';
		}
		return implode ( ' ' , $classes );
	}

	/**
	 * After theme set up
	 *
	 * @return void
	 */
	function after_setup_theme() {

		$this->add_image_sizes();

		$this->register_navigation_areas();

		$this->add_theme_supports();

	}

	/**
	 * Adds various theme supports.
	 *
	 * @return void
	 */
	function add_theme_supports()
	{

		$GLOBALS['content_width'] = apply_filters( 'diviner_archive_content_width', 920 );

		add_theme_support( 'automatic-feed-links' );

		$args = array(
			'default-image'      => '',
			'default-text-color' => substr(Customizer::SECTION_THEME_SETTING_COLOR_HEADER_TEXT_DEFAULT, 1 ),
			'width'              => 1000,
			'height'             => 250,
			'flex-width'         => true,
			'flex-height'        => true,
		);
		add_theme_support( 'custom-header', $args );

		$args = array(
			'default-color' => substr(Customizer::SECTION_THEME_SETTING_COLOR_BODY_BG_DEFAULT, 1 ),
		);
		add_theme_support( 'custom-background', $args );

		/**
		 * Add support for custom logo. Allow for setting
		 * logo for theme via WordPress customizer.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_theme_support/#custom-logo
		 */
		add_theme_support('custom-logo');

		/**
		 * Add support for head <title> tag. By adding `title-tag` support, we
		 * declare that this theme does not use a hard-coded <title> tag in
		 * the document head, and expect WordPress to provide it for us.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
		 */
		add_theme_support('title-tag');

		/**
		 * Enable custom color support
		 *
		 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/components/color-palette/
		 */
		add_theme_support( 'editor-color-palette', Swatches::get_colors() );

		/**
		 * Enable support for Post Thumbnails on posts and pages. Note that you
		 * can optionally pass a second argument, $args, with an array of
		 * the Post Types for which you want to enable this feature.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
		 */
		add_theme_support('post-thumbnails');

		/**
		 * Switch default core markup for search forms, comment forms, comment
		 * lists, gallery, and captions to output valid HTML5 markup.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_theme_support/#html5
		 */
		add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]);

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
			'primary' => __('Primary', 'diviner-archive'),
			'footer'  => __('Footer', 'diviner-archive'),
		]);
	}

	/**
	 * Determines if bright or dark
	 *
	 * @param  string   $hex   Hex color.
	 * @return bool
	 */
	static function is_dark($hex) {
		return static::get_brightness($hex) > 150;
	}

	/**
	 * Gets the brightness based on the hex
	 *
	 * @param  string   $hex   Hex color.
	 * @return float
	 */
	static function get_brightness($hex) {
		// returns brightness value from 0 to 255
		// strip off any leading #
		$hex = str_replace('#', '', $hex);
		$c_r = hexdec(substr($hex, 0, 2));
		$c_g = hexdec(substr($hex, 2, 2));
		$c_b = hexdec(substr($hex, 4, 2));

		return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
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
	 * Is a taxonomy term in a particular post type
	 *
	 * @param object $term
	 * @param string $post_type
	 * @return bool
	 */
	static public function is_taxonomy_in_post_type( $term, $post_type = 'post' ) {
		$taxonomies = get_object_taxonomies( (object) [
			'post_type' => $post_type
		] );
		return in_array( $term->taxonomy, $taxonomies );
	}

	/**
	 * Should display cards
	 *
	 * @return bool
	 */
	static public function should_display_cards( ) {
		if (is_post_type_archive( [ Archive_Item::NAME ] )) {
			return true;
		} else {
			$is_tax = is_tax();
			if ($is_tax) {
				$term = get_queried_object();
				if ( static::is_taxonomy_in_post_type($term, Archive_Item::NAME) ) {
					return true;
				} else {
					return false;
				}
			}
		}
		return false;
	}

	/**
	 * Renders out the index loop
	 *
	 * $taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type ) );
	 *
	 */
	function theme_index_content() {
		if (static::should_display_cards()) {
			template('partials/loop/card', []);
		} else {
			template('partials/loop/content', []);
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
		$menu = wp_nav_menu( [
			'theme_location' => 'footer',
			'echo' => false,
			'depth' => 1
		] );
		if ( empty( $menu ) ) {
			return '';
		}
		return sprintf(
			'<div class="footer-menu__wrap"><nav class="footer-menu"><div class="a11y-visual-hide">%s</div>%s</nav></div>',
			__( 'Footer Navigation', 'diviner-archive'),
			$menu
		);
	}

	/**
	 * Outputs the primary nav
	 *
	 */
	static public function the_primary_menu() {
		return sprintf(
			'<div class="primary-menu__wrap" data-js="primary-menu__wrap"><nav class="primary-menu"><button class="primary-menu__close" data-js="primary-menu__close"><span class="fa fa-times" aria-hidden="true"></span><span class="a11y-visual-hide">%s</span></button><div class="a11y-visual-hide">%s</div>%s</nav></div>',
			__( 'Close Navigation', 'diviner-archive'),
			__( 'Primary Navigation', 'diviner-archive'),
			wp_nav_menu( [
				'theme_location' => 'primary',
				'echo' => false,
				'depth' => 2
			] )
		);
	}

	/**
	 * Gets the header brand
	 *
	 * @return string
	 */
	static public function the_header_brand() {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

		$size_class = 'header__logo--square';
		if ( (int)$logo[1] > (int)$logo[2] ) {
			$size_class = 'header__logo--landscape';
		} else if ( (int)$logo[1] < (int)$logo[2] ) {
			$size_class = 'header__logo--portrait';
		}
		if ( has_custom_logo() ) {
			$brand = sprintf(
				'<div class="header__logo %s"><a href="%s" class="header__logo-link"><img src="%s" title="%s" class="header__logo-img"></a></div>',
				$size_class,
				get_home_url(),
				esc_url( $logo[0] ),
				get_bloginfo( 'name' )
			);
		} else {
			$brand = sprintf(
				'<div class="header__title"><a href="%s" class="header__title-link">%s</a></div>',
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
		$social_facebook = get_theme_mod(Customizer::SECTION_THEME_CONTENT_SETTING_SOCIAL_FACEBOOK );
		$social_instagram = get_theme_mod(Customizer::SECTION_THEME_CONTENT_SETTING_SOCIAL_INSTAGRAM );
		$social_twitter = get_theme_mod(Customizer::SECTION_THEME_CONTENT_SETTING_SOCIAL_TWITTER );

		if ( !empty( $social_facebook ) || !empty( $social_instagram ) || !empty( $social_twitter ) ) {
			$social_links = [];
			if ( !empty( $social_facebook ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-facebook-f"></span></a></li>',
					esc_attr( $social_facebook ),
					__( 'Facebook Link', 'diviner-archive' )
				);
			}
			if ( !empty( $social_instagram ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-instagram"></span></a></li>',
					esc_attr( $social_instagram ),
					__( 'Instagram Link', 'diviner-archive' )
				);
			}
			if ( !empty( $social_twitter ) ) {
				$social_links[] = sprintf(
					'<li class="social-links_item"><a href="%s" class="social-links_link"><div class="a11y-visual-hide">%s</div><span class="fab fa-twitter"></span></a></li>',
					esc_attr( $social_twitter ),
					__( 'Twitter Link', 'diviner-archive' )
				);
			}
			return sprintf(
				'<ul class="social-links">%s</ul>',
				implode ( '' , $social_links )
			);
		}

		return '';
	}

	/**
	 * Gets the footer copy
	 *
	 * @return string
	 */
	static function the_footer_copy () {
		$copy = get_theme_mod(Customizer::SECTION_THEME_CONTENT_SETTING_FOOTER_BODY );
		if ( !empty( $copy ) ) {
			return sprintf(
				'<div class="footer__copy d-content"><p>%s</p></div>',
				$copy
			);
		}
		return '';
	}

	/**
	 * Returns the version for assets
	 *
	 * @return string
	 */
	static function version() {
		$my_theme = wp_get_theme();
		$version = $my_theme->get( 'Version' );

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ) {
			$version = uniqid( 'version-dev-' );
		}

		return $version;
	}

	/**
	 * Gets the title
	 *
	 * @return string
	 */
	static function get_page_title() {
		$title = new \Diviner\Theme\Title();
		return $title->get_title();
	}

	/**
	 * Retrieve google fonts
	 */
	public function google_fonts() {
		$header_font_key = get_theme_mod(Customizer::SECTION_THEME_SETTING_FONT_HEADER, static::FONTS_DEFAULT_HEADER);
		$body_font_key = get_theme_mod(Customizer::SECTION_THEME_SETTING_FONT_BODY, static::FONTS_DEFAULT_BODY);
		$header_font_key = !empty($header_font_key) ? $header_font_key : static::FONTS_DEFAULT_HEADER;
		$body_font_key = !empty($body_font_key) ? $body_font_key : static::FONTS_DEFAULT_BODY;
		wp_enqueue_style( 'diviner-headings-fonts', '//fonts.googleapis.com/css?family='. urlencode($header_font_key) );
		wp_enqueue_style( 'diviner-body-fonts', '//fonts.googleapis.com/css?family='. urlencode($body_font_key) );
	}

	/**
	 * Renders awesome fonts
	 *
	 */
	public function awesome_fonts() {
		?>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/solid.css" integrity="sha384-aj0h5DVQ8jfwc8DA7JiM+Dysv7z+qYrFYZR+Qd/TwnmpDI6UaB3GJRRTdY8jYGS4" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/regular.css" integrity="sha384-l+NpTtA08hNNeMp0aMBg/cqPh507w3OvQSRoGnHcVoDCS9OtgxqgR7u8mLQv8poF" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/brands.css" integrity="sha384-1KLgFVb/gHrlDGLFPgMbeedi6tQBLcWvyNUN+YKXbD7ZFbjX6BLpMDf0PJ32XJfX" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/fontawesome.css" integrity="sha384-WK8BzK0mpgOdhCxq86nInFqSWLzR5UAsNg0MGX9aDaIIrFWQ38dGdhwnNCAoXFxL" crossorigin="anonymous">
		<?php
	}

}
