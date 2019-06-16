<?php

namespace Diviner\Admin;

use Diviner\Theme\General;
use Diviner\Admin\Controls\RichTextArea;

/**
 * Class Customizer
 *
 * Functions for customizer output and settings
 *
 * @package Diviner\Admin
 */
class Customizer {

	const PIMPLE_CONTAINER_NAME = 'admin.customizer';

	const SECTION_THEME_CONTENT = 'diviner_section_theme_content';

	const SECTION_THEME_CUSTOMIZATIONS  = 'diviner_section_theme_customizations';

	const SECTION_THEME_SETTING_COLOR_HEADER  = 'diviner_setting_color_header';
	const SECTION_THEME_CONTROL_COLOR_HEADER  = 'diviner_control_color_header';
	const SECTION_THEME_SETTING_COLOR_HEADER_DEFAULT  = '#777777';

	const SECTION_THEME_SETTING_COLOR_HEADER_TEXT  = 'diviner_setting_color_header_text';
	const SECTION_THEME_CONTROL_COLOR_HEADER_TEXT  = 'diviner_control_color_header_text';
	const SECTION_THEME_SETTING_COLOR_HEADER_TEXT_DEFAULT = '#ffffff';

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU  = 'diviner_setting_color_header_menu';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU  = 'diviner_control_color_header_menu';
	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_DEFAULT = '#F4D35E';

	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER  = 'diviner_setting_color_header_menu_hover';
	const SECTION_THEME_CONTROL_COLOR_HEADER_MENU_HOVER  = 'diviner_control_color_header_menu_hover';
	const SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER_DEFAULT = '#FFFFFF';

	const SECTION_THEME_SETTING_COLOR_FOOTER = 'diviner_setting_color_footer';
	const SECTION_THEME_CONTROL_COLOR_FOOTER = 'diviner_control_color_footer';
	const SECTION_THEME_SETTING_COLOR_FOOTER_DEFAULT = '#777777';

	const SECTION_THEME_SETTING_COLOR_FOOTER_TEXT  = 'diviner_setting_color_footer_text';
	const SECTION_THEME_CONTROL_COLOR_FOOTER_TEXT  = 'diviner_control_color_footer_text';
	const SECTION_THEME_SETTING_COLOR_FOOTER_TEXT_DEFAULT = '#FFFFFF';

	const SECTION_THEME_SETTING_COLOR_FOOTER_MENU  = 'diviner_setting_color_footer_menu';
	const SECTION_THEME_CONTROL_COLOR_FOOTER_MENU  = 'diviner_control_color_footer_menu';
	const SECTION_THEME_SETTING_COLOR_FOOTER_MENU_DEFAULT = '#F4D35E';

	const SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER  = 'diviner_setting_color_footer_menu_hover';
	const SECTION_THEME_CONTROL_COLOR_FOOTER_MENU_HOVER  = 'diviner_control_color_footer_menu_hover';
	const SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER_DEFAULT = '#FFFFFF';

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

	const SECTION_THEME_CONTENT_SETTING_FOOTER_BODY = 'diviner_setting_content_footer_copy';

	const SECTION_THEME_CONTENT_SETTING_SOCIAL_TWITTER = 'diviner_setting_content_social_twitter';
	const SECTION_THEME_CONTENT_SETTING_SOCIAL_FACEBOOK = 'diviner_setting_content_social_facebook';
	const SECTION_THEME_CONTENT_SETTING_SOCIAL_INSTAGRAM = 'diviner_setting_content_social_instagram';

	const SECTION_THEME_CONTENT_SETTING_SEARCH_PAGE = 'diviner_setting_content_search_page';


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

			/* Free form classic styles */
			.editor-styles-wrapper .wp-block-freeform blockquote {
				border-left-color: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-freeform .btn {
				background: <?php echo $color_btn_link; ?> !important;
			}

			.editor-styles-wrapper .wp-block-freeform hr {
				background: <?php echo $color_accent; ?> !important;
			}

			.editor-styles-wrapper .wp-block-freeform h1,
			.editor-styles-wrapper .wp-block-freeform h2,
			.editor-styles-wrapper .wp-block-freeform h3,
			.editor-styles-wrapper .wp-block-freeform h4,
			.editor-styles-wrapper .wp-block-freeform h5,
			.editor-styles-wrapper .wp-block-freeform h6 {
				font-family: '<?php echo $header_font_value; ?>' !important;
			}


		</style>
		<?php
	}


	public function customize_register( $wp_customize ) {
		$this->add_customize_section_content( $wp_customize );
		$this->add_customize_section_display( $wp_customize );
	}

	/**
	 * Attach the content customizer section
	 */
	public function add_customize_section_content ( $wp_customize ) {
		// Content Section
		$wp_customize->add_section( static::SECTION_THEME_CONTENT, array(
			'title'      => __('Diviner Theme Content','ncpr-diviner'),
			'priority'   => 30,
		) );

		// Footer
		$wp_customize->add_setting(static::SECTION_THEME_CONTENT_SETTING_FOOTER_BODY, [
			'default' => '',
		]);
		$wp_customize->add_control(new RichTextArea($wp_customize, static::SECTION_THEME_CONTENT_SETTING_FOOTER_BODY, [
			'type' => 'textarea',
			'section' => static::SECTION_THEME_CONTENT,
			'label' => __('Footer Copy', 'ncpr-diviner'),
			'description' => __('Appears in the footer under the navigation', 'ncpr-diviner'),
		]));

		$wp_customize->add_setting( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_FACEBOOK, array(
			'default' => '',
		) );
		$wp_customize->add_control( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_FACEBOOK, array(
			'type' => 'text',
			'section' => static::SECTION_THEME_CONTENT,
			'label' => __( 'Facebook Link' ),
			'description' => __( 'Ex: https://www.facebook.com/nytimes/', 'ncpr-diviner' ),
		) );

		$wp_customize->add_setting( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_TWITTER, array(
			'default' => '',
		) );
		$wp_customize->add_control( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_TWITTER, array(
			'type' => 'text',
			'section' => static::SECTION_THEME_CONTENT,
			'label' => __( 'Twitter Link' ),
			'description' => __( 'Ex: https://twitter.com/nytimes', 'ncpr-diviner' ),
		) );

		$wp_customize->add_setting( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_INSTAGRAM, array(
			'default' => '',
		) );
		$wp_customize->add_control( static::SECTION_THEME_CONTENT_SETTING_SOCIAL_INSTAGRAM, array(
			'type' => 'text',
			'section' => static::SECTION_THEME_CONTENT,
			'label' => __( 'Instagram Link' ),
			'description' => __( 'Ex: https://www.instagram.com/nytimes', 'ncpr-diviner' ),
		) );

		$wp_customize->add_setting( static::SECTION_THEME_CONTENT_SETTING_SEARCH_PAGE, array(
			'default' => '',
			'sanitize_callback' => [ $this, 'sanitize_dropdown_pages' ] ,
		) );
		$wp_customize->add_control( static::SECTION_THEME_CONTENT_SETTING_SEARCH_PAGE, array(
			'type' => 'dropdown-pages',
			'section' => static::SECTION_THEME_CONTENT,
			'label' => __( 'Nav Search Page' ),
			'description' => __( 'Select a page to link the search icon to in the navigation', 'ncpr-diviner' ),
		) );
	}

	function sanitize_dropdown_pages( $page_id, $setting ) {
		// Ensure $input is an absolute integer.
		$page_id = absint( $page_id );

		// If $page_id is an ID of a published page, return it; otherwise, return the default.
		return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	/**
	 * Attach the display customizer section
	 */
	public function add_customize_section_display ( $wp_customize ) {

		// Customization Section
		$wp_customize->add_section( static::SECTION_THEME_CUSTOMIZATIONS , array(
			'title'      => __('Diviner Theme Display','ncpr-diviner'),
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
			static::SECTION_THEME_SETTING_COLOR_FOOTER_TEXT,
			static::SECTION_THEME_CONTROL_COLOR_FOOTER_TEXT,
			__( 'Footer Text Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_FOOTER_TEXT_DEFAULT,
			__( 'Used for text in footer widgets', 'ncpr-diviner' )
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU,
			static::SECTION_THEME_CONTROL_COLOR_FOOTER_MENU,
			__( 'Footer Menu Button Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_DEFAULT
		);

		$this->setup_color_control(
			$wp_customize,
			static::SECTION_THEME_CUSTOMIZATIONS,
			static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER,
			static::SECTION_THEME_CONTROL_COLOR_FOOTER_MENU_HOVER,
			__( 'Footer Menu Button Hover Color', 'ncpr-diviner' ),
			static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER_DEFAULT
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

	/**
	 * Output up main customizer css
	 */
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

		.main__inner button,
		.main__inner .btn,
		.main__inner input[type='button'],
		.main__inner input[type='reset'],
		.main__inner input[type='submit'] {
			background-color: <?php echo $color_btn_link; ?>;
		}

		.main__inner button:hover,
		.main__inner button:focus,
		.main__inner .btn:hover,
		.main__inner .btn:focus,
		.main__inner input[type='button']:hover,
		.main__inner input[type='button']:focus,
		.main__inner input[type='reset']:hover,
		.main__inner input[type='reset']:focus,
		.main__inner input[type='submit']:hover,
		.main__inner input[type='submit']:focus {
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

		.d-content th,
		.th {
			font-family: '<?php echo $header_font_value; ?>' !important;
		}

		.d-content blockquote {
			border-left-color: <?php echo $color_accent; ?>;
		}

		.d-content blockquote p {
			font-family: '<?php echo $body_font_value; ?>';
		}

		.d-content hr:not(.is-style-dots) {
			background-color: <?php echo $color_accent; ?> !important;
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
		$color_footer_bbg = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER, static::SECTION_THEME_SETTING_COLOR_FOOTER_DEFAULT );
		$color_footer_text = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER_TEXT, static::SECTION_THEME_SETTING_COLOR_FOOTER_TEXT_DEFAULT);
		$color_footer_menu = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU, static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_DEFAULT);
		$color_footer_menu_hover = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER, static::SECTION_THEME_SETTING_COLOR_FOOTER_MENU_HOVER_DEFAULT);
		$color_navigation = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU, static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_DEFAULT );
		$color_navigation_hover = get_theme_mod(static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER, static::SECTION_THEME_SETTING_COLOR_HEADER_MENU_HOVER_DEFAULT );

		?>
		<style type="text/css">
			body .header {
				background-color: <?php echo $color_header_bg; ?>;
			}

			.header__menu-trigger span {
				color: <?php echo $color_navigation; ?> !important;
			}

			.header__menu-trigger:hover span,
			.header__menu-trigger:focus span {
				color: <?php echo $color_navigation_hover; ?> !important;
			}

			.header__title {
				font-family: "<?php echo $header_font_value; ?>" !important;
			}

			.header__menu-search span {
				color: <?php echo $color_navigation ?> !important;
			}

			.header__menu-search:hover span,
			.header__menu-search:focus span {
				color: <?php echo $color_navigation_hover ?> !important;
			}

			.primary-menu__wrap {
				background-color: <?php echo $color_header_bg; ?>;
			}

			.primary-menu .menu a,
			.primary-menu .menu a:visited {
				color: <?php echo $color_navigation ?>;
			}

			.primary-menu .menu a:hover,
			.primary-menu .menu a:focus {
				color: <?php echo $color_navigation_hover ?> !important;
			}

			.single-item__navigation a {
				background-color: <?php echo $color_btn_link; ?> !important;
			}

			.single-item__navigation a:hover,
			.single-fitem__navigation a:focus {
				background-color: <?php echo General::luminance( substr($color_btn_link, 1), -0.2 ); ?> !important;
			}

			@media screen and (min-width: 960px) {
				.primary-menu__wrap {
					background-color: transparent;
				}

				.primary-menu .menu a,
				.primary-menu .menu a:visited {
					color: <?php echo $color_navigation ?>;
					background-color: transparent;
				}
				.primary-menu .menu a:focus,
				.primary-menu .menu a:hover {
					color: <?php echo $color_navigation_hover ?>;
					background-color: transparent;
				}

				.primary-menu .menu .children a,
				.primary-menu .menu .children a:visited,
				.primary-menu .menu .sub-menu a,
				.primary-menu .menu .sub-menu a:visited {
					color: <?php echo $color_subheader_text_desktop; ?>;
				}

				.primary-menu .menu .children a:focus,
				.primary-menu .menu .children a:hover,
				.primary-menu .menu .sub-menu a:focus,
				.primary-menu .menu .sub-menu a:hover {
					color: <?php echo $color_subheader_text_desktop; ?>;
					text-decoration: underline;
				}
			}

			body .footer {
				color: <?php echo $color_footer_text; ?>;
				background-color: <?php echo $color_footer_bbg; ?>;
			}

			body .footer p {
				color: <?php echo $color_footer_text; ?>;
			}

			body .footer a {
				color: <?php echo $color_footer_menu; ?>;
			}

			body .footer a:hover,
			body .footer a:focus {
				color: <?php echo $color_footer_menu_hover; ?>;
			}

			.footer .menu a {
				font-family: "<?php echo $header_font_value; ?>" !important;
				color: <?php echo $color_footer_menu; ?>;
			}

			.footer .menu a,
			.footer a.social-links_link {
				color: <?php echo $color_footer_menu; ?>;
				border-color: <?php echo $color_footer_menu; ?>;
			}

			.footer .menu a:hover,
			.footer .menu a:focus,
			.footer a.social-links_link:hover,
			.footer a.social-links_link:focus {
				color: <?php echo $color_footer_menu_hover; ?>;
				border-color: <?php echo $color_footer_menu_hover; ?>;
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
