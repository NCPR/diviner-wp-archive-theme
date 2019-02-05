<?php

namespace Diviner\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

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

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU  = 'diviner_setting_color_header_menu';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU  = 'diviner_control_color_header_menu';

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER  = 'diviner_setting_color_header_menu_hover';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER  = 'diviner_control_color_header_menu_hover';

	const SECTION_THEME_SETTING_COLOR_FOOTER = 'diviner_setting_color_footer';
	const SECTION_THEME_CONTROL_COLOR_FOOTER = 'diviner_control_color_footer';

	const SECTION_THEME_SETTING_COLOR_BUTTON_LINK = 'diviner_setting_color_button_link';
	const SECTION_THEME_CONTROL_COLOR_BUTTON_LINK = 'diviner_control_color_button_link';

	const SECTION_THEME_SETTING_COLOR_ACCENT = 'diviner_setting_color_accent';
	const SECTION_THEME_CONTROL_COLOR_ACCENT = 'diviner_control_color_accent';


	public function hooks() {
		add_action( 'customize_register', [$this, 'customize_register'], 10, 1 );
		add_action( 'wp_head', [$this, 'customize_css'] );
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
			'#DDDDDD'
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU,
			static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU,
			__( 'Header Menu Button Color', 'ncpr-diviner' ),
			'#999999'
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER,
			static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER,
			__( 'Header Menu Button Hover Color', 'ncpr-diviner' ),
			'#000000'
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_FOOTER,
			static::SECTION_THEME_CONTROL_COLOR_FOOTER,
			__( 'Footer Color', 'ncpr-diviner' ),
			'#777777'
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK,
			static::SECTION_THEME_CONTROL_COLOR_BUTTON_LINK,
			__( 'Button and Link Color', 'ncpr-diviner' ),
			'blue'
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_ACCENT,
			static::SECTION_THEME_CONTROL_COLOR_ACCENT,
			__( 'Accent Color', 'ncpr-diviner' ),
			'orange'
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


	public function customize_css()
	{
		?>
		<style type="text/css">
			.header {
				background-color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_HEADER, '#DDDDDD'); ?>;
			}
			@media screen and (min-width: 960px) {
				.primary-menu a,
				.primary-menu a:visited {
					color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU, '#999999'); ?>;
				}
				.primary-menu a:focus,
				.primary-menu a:hover {
					color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER, '#000000'); ?>;
				}
			}
			.footer {
				background-color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_HEADER, '#777777'); ?>;
			}

			.d-content {
				a {
					color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_BUTTON_LINK, 'blue'); ?>;
				}

				.btn {
					background-color: <?php echo get_theme_mod(static::SECTION_THEME_CONTROL_COLOR_BUTTON_LINK, 'blue'); ?>;
				}
			}
		</style>
		<?php
	}

}
