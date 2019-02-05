<?php

namespace Diviner\Admin;

/**
 * Classic Editor stuff
 *
 * @package Diviner\Admin
 */
class ClassicEditor {

	public function hooks() {
		add_action( 'after_setup_theme', [ $this, 'visual_editor_styles' ], 10, 0 );
		add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_body_class' ], 10, 1 );
		add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_styles_dropdown' ], 10, 1 );
		add_filter( 'tiny_mce_before_init', [ $this, 'add_editor_customizer_styles' ], 10, 1 );
		add_filter( 'mce_buttons', [ $this, 'mce_buttons' ], 10, 1 );
	}

	/**
	 * Visual Editor Styles
	 */
	public function visual_editor_styles() {

		// wp_register_style( 'editor-styles', get_template_directory_uri().'/public/css/editor-styles.css', false, '1.0.0' );
		// wp_enqueue_style( 'editor-styles' );


		$css_dir    = trailingslashit( get_template_directory_uri() ) . 'public/css/';
		$editor_css = 'editor-styles.css';

		// Production
		if ( ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false ) {
			$css_dir    = trailingslashit( get_template_directory_uri() ) . 'public/css/';
			$editor_css = 'editor-styles.css';
		}

		add_editor_style( $css_dir . $editor_css );

	}

	function add_editor_customizer_styles( $mceInit ) {
		$styles = Customizer::get_customize_content_css();
		$styles = str_replace(PHP_EOL, '', trim($styles));
		if ( !isset( $mceInit['content_style'] ) ) {
			$mceInit['content_style'] = $styles . ' ';
		} else {
			$mceInit['content_style'] .= ' ' . $styles . ' ';
		}
		return $mceInit;
	}

	/**
	 * Visual Editor Body Class
	 */
	public function visual_editor_body_class( $settings ) {

		$settings['body_class'] .= ' d-content';

		return $settings;

	}

	public function mce_buttons( $buttons ) {
		$tag_select = array_shift( $buttons );
		array_unshift( $buttons, $tag_select, 'styleselect' );
		return $buttons;
	}

	public function visual_editor_styles_dropdown( $settings ) {
		$style_formats = [
			[
				'title'    => __( 'Button', 'ncpr-diviner' ),
				'selector' => 'button,a',
				'classes'  => 'btn',
				'wrapper'  => false,
			],
		];
		$settings[ 'style_formats' ] = json_encode( $style_formats );
		return $settings;
	}


	/*
	 * add_filter( 'mce_buttons', function ( $settings ) use ( $container ) {
			return $container[ 'theme.resources.editor_formats' ]->mce_buttons( $settings );
		}, 10, 1 );
		add_filter( 'tiny_mce_before_init', function ( $settings ) use ( $container ) {
			return $container[ 'theme.resources.editor_formats' ]->visual_editor_styles_dropdown( $settings );
		}, 10, 1 );
	 */

}
