<?php

namespace Diviner\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Classic Editor stuff
 *
 * @package Diviner\Admin
 */
class ClassicEditor {

	public function hooks() {
		add_action( 'after_setup_theme', [ $this, 'visual_editor_styles' ], 10, 0 );
		// add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_body_class' ], 10, 1 );
		add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_styles_dropdown' ], 10, 1 );
		add_filter( 'mce_buttons', [ $this, 'mce_buttons' ], 10, 1 );
	}

	/**
	 * Visual Editor Styles
	 */
	public function visual_editor_styles() {

		$css_dir    = trailingslashit( get_template_directory_uri() ) . 'css/admin/';
		$editor_css = 'editor-style.css';

		// Production
		if ( ! defined( 'SCRIPT_DEBUG' ) || SCRIPT_DEBUG === false ) {
			$css_dir    = trailingslashit( get_template_directory_uri() ) . 'css/admin/dist/';
			$editor_css = 'editor-style.min.css';
		}

		add_editor_style( $css_dir . $editor_css );

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
