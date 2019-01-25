<?php

namespace Diviner\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

use Diviner\Theme\General;

/**
 * Class Settings
 *
 * Functions for Settings
 *
 * @package Diviner\Admin
 */
class Customizer {


	const SECTION_THEME_CUSTOMIZATIONS  = 'diviner_section_theme_customizations';

	const SECTION_THEME_SETTING_COLOR_HEADER  = 'diviner_setting_color_header';
	const SECTION_THEME_CONTROL_COLOR_HEADER  = 'diviner_control_color_header';
	const SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT  = '#DDDDDD';

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU  = 'diviner_setting_color_header_menu';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU  = 'diviner_control_color_header_menu';
	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_DEFAULT = '#999999';

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER  = 'diviner_setting_color_header_menu_hover';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER  = 'diviner_control_color_header_menu_hover';
	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER_DEFAULT = '#000000';

	const SECTION_THEME_SETTING_COLOR_FOOTER = 'diviner_setting_color_footer';
	const SECTION_THEME_CONTROL_COLOR_FOOTER = 'diviner_control_color_footer';
	const SECTION_THEME_SETTING_COLOR_FOOTER_DEFAULT = '#777777';

	const SECTION_THEME_SETTING_COLOR_BUTTON_LINK = 'diviner_setting_color_button_link';
	const SECTION_THEME_CONTROL_COLOR_BUTTON_LINK = 'diviner_control_color_button_link';
	const SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT = '#cc8400';

	const SECTION_THEME_SETTING_COLOR_ACCENT = 'diviner_setting_color_accent';
	const SECTION_THEME_CONTROL_COLOR_ACCENT = 'diviner_control_color_accent';
	const SECTION_THEME_SETTING_COLOR_ACCENT_DEFAULT = '#0048cc';

	const SECTION_THEME_SETTING_FONT_HEADER = 'diviner_setting_font_header'; // default from
	const SECTION_THEME_CONTROL_FONT_HEADER = 'diviner_control_font_header';

	const SECTION_THEME_SETTING_FONT_BODY = 'diviner_setting_font_body';
	const SECTION_THEME_CONTROL_FONT_BODY = 'diviner_control_font_body';

	const CUSTOMIZER_FONT_CLASSNAME_HEADER = 'diviner-comstumizer-font-header';
	const CUSTOMIZER_FONT_CLASSNAME_BODY = 'diviner-comstumizer-font-body';


	public function hooks() {
		add_action( 'customize_register', [$this, 'customize_register'], 10, 1 );
		add_action( 'wp_enqueue_scripts', [$this, 'customize_css'] );
	}

	public function customize_register( $wp_customize ) {
		$wp_customize->add_section( static::SECTION_THEME_CUSTOMIZATIONS , array(
			'title'      => __('Theme Customizations','ncpr-diviner'),
			'priority'   => 30,
		) );

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER,
			static::SECTION_THEME_CONTROL_COLOR_HEADER,
			__( 'Header Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU,
			static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU,
			__( 'Header Menu Button Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER,
			static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER,
			__( 'Header Menu Button Hover Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_FOOTER,
			static::SECTION_THEME_CONTROL_COLOR_FOOTER,
			__( 'Footer Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_FOOTER_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK,
			static::SECTION_THEME_CONTROL_COLOR_BUTTON_LINK,
			__( 'Button and Link Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_ACCENT,
			static::SECTION_THEME_CONTROL_COLOR_ACCENT,
			__( 'Accent Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_ACCENT_DEFAULT
		);

		$this->fonts_sections($wp_customize);
	}

	private function fonts_sections( $wp_manager ) {

		$font_choices = General::FONTS;
		$wp_manager->add_setting( static::SECTION_THEME_SETTING_FONT_HEADER, array(
				'sanitize_callback' => [$this, 'sanitize_fonts'],
				'default' => General::FONTS_DEFAULT_HEADER,
				'transport' => 'refresh',
			)
		);
		$wp_manager->add_control( static::SECTION_THEME_CONTROL_FONT_HEADER, array(
				'type' => 'select',
				'label' => __('Header Font', 'ncpr-diviner'),
				'description' => __('Select your desired font for the headings.', 'ncpr-diviner'),
				'section' => static::SECTION_THEME_CUSTOMIZATIONS,
				'choices' => $font_choices,
				'settings' => static::SECTION_THEME_SETTING_FONT_HEADER,
			)
		);

		$wp_manager->add_setting( static::SECTION_THEME_SETTING_FONT_BODY, array(
				'sanitize_callback' => [$this, 'sanitize_fonts'],
				'default' => General::FONTS_DEFAULT_BODY,
				'transport' => 'refresh',
			)
		);
		$wp_manager->add_control( static::SECTION_THEME_CONTROL_FONT_BODY, array(
				'type' => 'select',
				'label' => __('Body Font', 'ncpr-diviner'),
				'description' => __('Select your desired font for the body.', 'ncpr-diviner'),
				'section' => static::SECTION_THEME_CUSTOMIZATIONS,
				'choices' => $font_choices,
				'settings' => static::SECTION_THEME_SETTING_FONT_BODY,
			)
		);

	}

	private function setup_color_control( $wp_customize, $section, $setting_name, $control_name, $control_title, $default = '#000000' ) {
		$wp_customize->add_setting( $setting_name , array(
			'default'   => $default,
			'transport' => 'refresh',
		) );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $control_name, array(
			'label'    => $control_title,
			'section'  => $section,
			'settings' => $setting_name,
		) ) );
	}

	public function sanitize_fonts( $input ) {
		$valid = General::FONTS;
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}

	public function customize_css()
	{
		$header_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_HEADER, General::FONTS_DEFAULT_HEADER);
		$header_font_value = General::FONTS[$header_font_key];

		$body_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_BODY, General::FONTS_DEFAULT_BODY);
		$body_font_value = General::FONTS[$body_font_key];

		$color_btn_link = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK, static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT);

		?>
		<style type="text/css">
			.header {
				background-color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER ); ?>;
			}

			.primary-menu .menu a,
			.primary-menu .menu a:visited {
				background-color: <?php echo $color_btn_link; ?>;
			}

			.primary-menu .menu a:hover,
			.primary-menu .menu a:focus {
				background-color: <?php echo General::luminance( substr($color_btn_link, 1), -0.2 ); ?>;
			}

			@media screen and (min-width: 960px) {
				.primary-menu .menu a,
				.primary-menu .menu a:visited {
					color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU); ?>;
					background-color: transparent;
				}
				.primary-menu .menu a:focus,
				.primary-menu .menu a:hover {
					color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER); ?>;
					background-color: transparent;
				}
			}
			.footer {
				background-color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER); ?>;
			}

			.d-content a {
				color: <?php echo $color_btn_link; ?>;
			}
			.d-content .btn {
				background-color: <?php echo $color_btn_link; ?>;
			}

			.d-content h1,
			.d-content h2,
			.d-content h3,
			.d-content h4,
			.d-content h5 {
				font-family: '<?php echo $header_font_value; ?>';
			}
			.sidebar h1,
			.sidebar h2,
			.sidebar h3,
			.sidebar h4,
			.sidebar h5 {
				font-family: '<?php echo $header_font_value; ?>';
			}
			.primary-menu a {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}
			body,
			.d-content {
				font-family: '<?php echo $body_font_value; ?>';
			}
			.footer {
				font-family: '<?php echo $body_font_value; ?>';
			}
			.<?php echo static::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?> {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}
			.<?php echo static::CUSTOMIZER_FONT_CLASSNAME_BODY; ?> {
				font-family: '<?php echo $body_font_value; ?>' !important;
			}

			.browse-app h1,
			.browse-app h2,
			.browse-app h3,
			.browse-app h4,
			.browse-app h5,
			.browse-app h6 {
				font-family: '<?php echo $header_font_value; ?>';
			}

		</style>
		<?php
	}

}
