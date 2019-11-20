<?php

namespace Diviner_Archive\Admin;

/**
 * Classic Editor stuff
 *
 * @package Diviner_Archive\Admin
 */
class Diviner_Archive_Editor {

	const PIMPLE_CONTAINER_NAME = 'admin.classic_editor';

	public function hooks() {
		// add_action( 'admin_init', [ $this, 'visual_editor_styles' ], 10, 0 );  // if add_theme_support('editor-styles');
		add_action( 'enqueue_block_assets', [ $this,'block_editor_assets' ] );
		add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_body_class' ], 10, 1 );
		add_filter( 'tiny_mce_before_init', [ $this, 'visual_editor_styles_dropdown' ], 10, 1 );
		add_filter( 'tiny_mce_before_init', [ $this, 'add_editor_customizer_styles' ], 10, 1 );
		add_filter( 'mce_buttons', [ $this, 'mce_buttons' ], 10, 1 );
	}

	/**
	 * Block Editor Assets
	 */
	public function block_editor_assets() {
		$css_dir    = trailingslashit( get_template_directory_uri() ) . 'public/css/';
		$editor_css = 'block-editor-styles.min.css';
		wp_enqueue_style(
			'diviner-block-editor-styles', // Handle.
			$css_dir . $editor_css, // Block editor CSS.
			[], // Dependency to include the CSS after it.
			\Diviner_Archive\Theme\Diviner_Archive_General::version()
		);
	}

	/**
	 * Visual Editor Styles
	 */
	public function visual_editor_styles() {
		$css_dir    = '/public/css/';
		$editor_css = 'editor-styles.min.css';
		add_editor_style( $css_dir . $editor_css );

	}

	/**
	 * Visual Editor Custom Styles
	 */
	function add_editor_customizer_styles( $mceInit ) {
		ob_start();
		Diviner_Archive_Customizer::output_customize_content_css();
		$styles = ob_get_clean();
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

		if ( !isset($settings['body_class']) ) {
			$settings['body_class'] = '';
		}
		$settings['body_class'] .= ' d-content';

		return $settings;

	}

	/**
	 * Visual Editor Buttons
	 */
	public function mce_buttons( $buttons ) {
		$tag_select = array_shift( $buttons );
		array_unshift( $buttons, $tag_select, 'styleselect' );
		return $buttons;
	}

	/**
	 * Visual Editor Custom Styles
	 */
	public function visual_editor_styles_dropdown( $settings ) {
		$style_formats = [
			[
				'title'    => __( 'Button', 'diviner-archive' ),
				'selector' => 'button,a',
				'classes'  => 'btn',
				'wrapper'  => false,
			],
		];
		$settings[ 'style_formats' ] = json_encode( $style_formats );
		return $settings;
	}

}
