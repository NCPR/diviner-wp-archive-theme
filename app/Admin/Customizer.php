<?php

namespace Diviner\Admin;

use Diviner\Theme\General;

/**
 * Class Customizer
 *
 * Functions for customizer output and settings
 *
 * @package Diviner\Admin
 */
class Customizer {

	const SECTION_THEME_CUSTOMIZATIONS  = 'diviner_section_theme_customizations';

	const SECTION_THEME_SETTING_COLOR_HEADER  = 'diviner_setting_color_header';
	const SECTION_THEME_CONTROL_COLOR_HEADER  = 'diviner_control_color_header';
	const SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT  = '#DDDDDD';

	const SECTION_THEME_SETTING_COLOR_HEADER_TEXT  = 'diviner_setting_color_header_text';
	const SECTION_THEME_CONTROL_COLOR_HEADER_TEXT  = 'diviner_control_color_header_text';
	const SECTION_THEME_SETTING_COLOR_HEADER_TEXT_DEFAULT = '#dddddd';

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

	const CUSTOMIZER_FONT_CLASSNAME_HEADER = 'diviner-costumizer-font-header';
	const CUSTOMIZER_FONT_CLASSNAME_BODY = 'diviner-costumizer-font-body';


	public function hooks() {
		add_action( 'customize_register', [$this, 'customize_register'], 10, 1 );
		add_action( 'wp_enqueue_scripts', [$this, 'customize_css'] );
		add_action( 'enqueue_block_assets', [ $this,'block_editor_assets' ] );
	}

	public function block_editor_assets() {
		$this->block_styles();
	}

	public function block_styles() {
		$header_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_HEADER, General::FONTS_DEFAULT_HEADER);
		$header_font_value = General::get_font_value_from_key($header_font_key);
		$body_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_BODY, General::FONTS_DEFAULT_BODY);
		$body_font_value = General::get_font_value_from_key($body_font_key);
		$color_btn_link = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK, static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT);
		$color_accent = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_ACCENT, static::SECTION_THEME_SETTING_COLOR_ACCENT_DEFAULT);
		?>
		<style type="text/css">
			.edit-post-visual-editor.editor-styles-wrapper {
				font-family: '<?php echo $body_font_value; ?>';
			}

			.editor-post-title__block .editor-post-title__input,
			.editor-post-title h1,
			.editor-post-title h2,
			.editor-post-title h3,
			.editor-post-title h4,
			.editor-post-title h5 {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}

			.editor-rich-text,
			.editor-rich-text p {
				font-family: '<?php echo $body_font_value; ?>' !important;
			}

			.editor-styles-wrapper .editor-block-list__block h1.editor-rich-text__tinymce,
			.editor-styles-wrapper .editor-block-list__block h2.editor-rich-text__tinymce,
			.editor-styles-wrapper .editor-block-list__block h3.editor-rich-text__tinymce,
			.editor-styles-wrapper .editor-block-list__block h4.editor-rich-text__tinymce,
			.editor-styles-wrapper .editor-block-list__block h5.editor-rich-text__tinymce,
			.editor-styles-wrapper .editor-block-list__block h6.editor-rich-text__tinymce {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}

			.editor-styles-wrapper .wp-block-cover .editor-rich-text__tinymce {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}

			.editor-styles-wrapper .wp-block-separator:not(.is-style-dots) {
				background-color: <?php echo $color_accent; ?> !important;
				border-bottom-color: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-separator:not(.is-style-wide):not(.is-style-dots)::before {
				background: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-separator.is-style-dots:before {
				color: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large) {
				border-left-color: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-pullquote {
				border-top-color: <?php echo $color_accent; ?> !important;
				border-bottom-color: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-button .wp-block-button__link {
				background: <?php echo $color_btn_link; ?> !important;
			}

			.editor-styles-wrapper .wp-block-button .wp-block-button__link:hover,
			.editor-styles-wrapper .wp-block-button .wp-block-button__link:focus {
				background-color: <?php echo General::luminance( substr($color_btn_link, 1), -0.2 ); ?> !important;
			}

			.editor-styles-wrapper .wp-block-freeform blockquote {
				border-left-color: <?php echo $color_accent; ?> !important;
			}


		</style>
		<?php
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
			__( 'Header Background Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_HEADER_TEXT,
			static::SECTION_THEME_CONTROL_COLOR_HEADER_TEXT,
			__( 'Header Text Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_HEADER_TEXT_DEFAULT,
			__( 'Used for the tagline or site title when there is no logo', 'ncpr-diviner' )
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
			__( 'Footer Background Color', 'ncpr-diviner' ),
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

	private function setup_color_control( $wp_customize, $section, $setting_name, $control_name, $control_title, $default = '#000000', $description = NULL ) {
		$wp_customize->add_setting( $setting_name , array(
			'default'   => $default,
			'transport' => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $control_name, array(
			'label'        => $control_title,
			'section'      => $section,
			'settings'     => $setting_name,
			'description' => $description,
		) ) );
	}

	public function sanitize_fonts( $input ) {
		$valid = General::FONTS;
		return ( array_key_exists( $input, $valid ) ? $input : General::FONTS_DEFAULT_BODY );
	}

	static public function get_customize_content_css() {
		$header_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_HEADER, General::FONTS_DEFAULT_HEADER);
		$header_font_value = General::get_font_value_from_key($header_font_key);
		$body_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_BODY, General::FONTS_DEFAULT_BODY);
		$body_font_value = General::get_font_value_from_key($body_font_key);
		$color_btn_link = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK, static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT);
		$color_accent = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_ACCENT, static::SECTION_THEME_SETTING_COLOR_ACCENT_DEFAULT);
		$color_header_text = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_TEXT, static::SECTION_THEME_SETTING_COLOR_HEADER_TEXT_DEFAULT);
		$color_header_text_hover = General::is_dark($color_header_text) ? General::luminance( substr($color_header_text, 1), 0.7 ) : General::luminance( substr($color_header_text, 1), -0.7 );

		ob_start();
		?>
		.main,
		.main form,
		.main button,
		.main input,
		.main select,
		.main textarea {
			font-family: '<?php echo $body_font_value; ?>';
		}

		.main button,
		.main input[type="button"],
		.main input[type="reset"],
		.main input[type="submit"] {
			background-color: <?php echo $color_btn_link; ?>;
		}

		.main button:hover,
		.main button:focus,
		.main input[type="button"]:hover,
		.main input[type="button"]:focus,
		.main input[type="reset"]:hover,
		.main input[type="reset"]:focus,
		.main input[type="submit"]:hover,
		.main input[type="submit"]:focus {
			background-color: <?php echo General::luminance( substr($color_btn_link, 1), -0.2 ); ?>;
		}

		.d-content {
			font-family: '<?php echo $body_font_value; ?>';
		}
		.<?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?> {
			font-family: '<?php echo $header_font_value; ?>' !important;
		}
		.<?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_BODY; ?> {
			font-family: '<?php echo $body_font_value; ?>' !important;
		}
		.header__title a,
		.header__title a:visited {
			color: <?php echo $color_header_text ?>;
		}
		.header__title a:hover,
		.header__title a:focus,
		.header__title a:active {
			color: <?php echo $color_header_text_hover ?>;
		}
		.header__lead {
			color: <?php echo $color_header_text ?>;
		}

		.main__inner a {
			color: <?php echo $color_btn_link; ?>;
		}

		input:focus,
		button:focus,
		textarea:focus,
		select:focus {
			border-color: <?php echo $color_btn_link; ?> !important;
		}

		.react-select-container .react-select__control.react-select__control--is-focused {
			border-color: <?php echo $color_btn_link; ?> !important;
		}

		.main label {
			font-family: '<?php echo $body_font_value; ?>' !important;
		}

		.d-content h1,
		.h1,
		.d-content h2,
		.h2,
		.d-content h3,
		.h3,
		.d-content h4,
		.h4,
		.d-content h5,
		.h5,
		.d-content h6,
		.h6 {
			font-family: '<?php echo $header_font_value; ?>' !important;
		}

		.d-content blockquote {
			border-left-color: <?php echo $color_accent; ?>;;
		}

		.d-content blockquote p {
			font-family: '<?php echo $body_font_value; ?>';
		}

		.footer {
			font-family: '<?php echo $body_font_value; ?>';
		}
		/* Blocks */
		.d-content .wp-block-cover .wp-block-cover-text {
			font-family: '<?php echo $header_font_value; ?>';
		}

		.d-content .wp-block-button__link,
		.d-content .wp-block-button .wp-block-button__link {
			background-color: <?php echo $color_btn_link; ?> !important;
		}

		.d-content .wp-block-button .wp-block-button__link:hover,
		.d-content .wp-block-button .wp-block-button__link:focus {
			background-color: <?php echo General::luminance( substr($color_btn_link, 1), -0.2 ); ?> !important;
		}

		.d-content .wp-block-separator:not(.is-style-dots) {
			background-color: <?php echo $color_accent; ?> !important;
		}

		.d-content .wp-block-separator.is-style-dots:before {
			color: <?php echo $color_accent; ?> !important;
		}

		.d-content .wp-block-separator:not(.is-style-wide):not(.is-style-dots)::before {
			background: <?php echo $color_accent; ?> !important;
		}

		.d-content .wp-block-quote:not(.is-style-solid-color) {
			border-left-color: <?php echo $color_accent; ?> !important;
		}

		.d-content .wp-block-pullquote blockquote {
			border-top-color: <?php echo $color_accent; ?> !important;
			border-bottom-color: <?php echo $color_accent; ?> !important;
		}

		.d-content .wp-block-freeform blockquote {
			border-left-color: <?php echo $color_accent; ?> !important;
		}

		<?php
		$styles = ob_get_clean();
		return $styles;
	}

	public function customize_css()
	{
		$header_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_HEADER, General::FONTS_DEFAULT_HEADER);
		$header_font_value = General::get_font_value_from_key($header_font_key);
		$body_font_key = get_theme_mod(static::SECTION_THEME_SETTING_FONT_BODY, General::FONTS_DEFAULT_BODY);
		$body_font_value = General::get_font_value_from_key($body_font_key);
		$color_btn_link = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK, static::SECTION_THEME_SETTING_COLOR_BUTTON_LINK_DEFAULT);
		$color_header_bg = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER, static::SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT );
		$color_subheader_text_desktop = General::is_dark($color_header_bg) ? $color_header_bg : 'black';
		?>
		<style type="text/css">
			body .header {
				background-color: <?php echo $color_header_bg; ?>;
			}

			.header__menu-trigger span {
				color: <?php echo $color_header_bg; ?> !important;
			}

			.header__title {
				font-family: "<?php echo $header_font_value; ?>" !important;
			}

			.header__menu-trigger:hover span,
			.header__menu-trigger:focus span {
				color: <?php echo $color_btn_link; ?> !important;
			}

			.primary-menu .menu a,
			.primary-menu .menu a:visited {
				color: <?php echo $color_btn_link; ?>;
			}

			.primary-menu .menu a:hover,
			.primary-menu .menu a:focus {
				color: <?php echo General::luminance( substr($color_btn_link, 1), -0.8 ); ?>;
			}

			@media screen and (min-width: 960px) {
				.primary-menu .menu a,
				.primary-menu .menu a:visited {
					color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU, static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_DEFAULT ); ?>;
					background-color: transparent;
				}
				.primary-menu .menu a:focus,
				.primary-menu .menu a:hover {
					color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER, static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER_DEFAULT ); ?>;
					background-color: transparent;
				}

				.primary-menu .menu .sub-menu a,
				.primary-menu .menu .sub-menu a:visited {
					color: <?php echo $color_subheader_text_desktop; ?>;
				}

				.primary-menu .menu .sub-menu a:focus,
				.primary-menu .menu .sub-menu a:hover {
					color: <?php echo $color_subheader_text_desktop; ?>;
					text-decoration: underline;
				}

			}

			body .footer {
				background-color: <?php echo get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER, static::SECTION_THEME_SETTING_COLOR_FOOTER_DEFAULT ); ?>;
			}

			.single-item__header .h1,
			.single-item__header .h2,
			.single-item__header .h3,
			.single-item__header .h4,
			.single-item__header .h5,
			.single-item__header .h6 {
				font-family: "<?php echo $header_font_value; ?>";
			}

			.primary-menu a {
				font-family: "<?php echo $header_font_value; ?>" !important;
			}

			.footer {
				font-family: "<?php echo $body_font_value; ?>";
			}

			.browse-app h1,
			.browse-app h2,
			.browse-app h3,
			.browse-app h4,
			.browse-app h5,
			.browse-app h6 {
				font-family: "<?php echo $header_font_value; ?>";
			}
			<?php // get d-content specific
			echo static::get_customize_content_css(); ?>
		</style>
		<?php
	}

}
