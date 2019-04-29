<?php

namespace Diviner\Blocks;

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Diviner\Theme\Swatches;
use Diviner\Admin\General;
use Awps\FontAwesome;

/**
 * Call To Action
 *
 * @package Diviner\Admin\Blocks
 */
class Call_To_Action {

	const BLOCK_ID = 'diviner_block_cta';
	const BLOCK_TITLE = 'diviner_block_cta_title';
	const BLOCK_COLOR = 'diviner_block_cta_color';
	const BLOCK_TEXT_COLOR = 'diviner_block_cta_text_color';
	const BLOCK_TEXT_COLOR_HOVER = 'diviner_block_cta_text_color_hover';
	const BLOCK_BG_IMG = 'diviner_block_cta_bg_img';
	const BLOCK_ICON = 'diviner_block_cta_icon';
	const BLOCK_THEME = 'diviner_block_cta_theme';
	const BLOCK_LINK = 'diviner_block_cta_link';
	const BLOCK_PAGE = 'diviner_block_cta_page';
	const BLOCK_SUBTITLE = 'diviner_block_cta_subtitle';


	/**
	 * Custom Related Archive Items Block
	 */
	public function __construct() {
		Block::make( static::BLOCK_ID, __( 'Diviner Call To Action', 'ncpr-diviner' ) )
			->add_fields( [
				Field::make( 'text', static::BLOCK_TITLE, __( 'Title', 'ncpr-diviner' ) )->set_default_value( __( 'Promo Title', 'ncpr-diviner' ) ),
				$this->get_color_field(),
				$this->get_color_text_field(),
				$this->get_color_text_hover_field(),
				Field::make( 'image', static::BLOCK_BG_IMG, __( 'Background Image', 'ncpr-diviner' ) ),
				$this->get_icon_field(),
				$this->get_page_link(),
				$this->get_manual_link(),
				Field::make( 'text', static::BLOCK_SUBTITLE, __( 'Promo Subtitle', 'ncpr-diviner' ) )
			])
		->set_icon( 'star-filled' )
		->set_render_callback([ $this, 'render' ]); // ToDo figure out typecasting
	}

	/**
	 * Get manual link field
	 *
	 * @return Mixed
	 */
	public function get_manual_link() {
		return Field::make( 'text', static::BLOCK_LINK, __( 'Link to URL', 'ncpr-diviner' ) )
			->set_help_text( __( 'If you want to link this call to action to some other URL', 'ncpr-diviner' ) );
	}

	/**
	 * Get page link field
	 *
	 * @throws
	 *
	 * @return Mixed
	 */
	public function get_page_link() {
		$container = \Tonik\Theme\App\Main::instance()->container();
		return Field::make( 'select', static::BLOCK_PAGE, __( 'Link to Page', 'ncpr-diviner' ) )
			->add_options( [ $container[General::PIMPLE_CONTAINER_NAME], 'get_pages' ] )
			->set_help_text( __( 'If you want to link this call to action to a page on your site', 'ncpr-diviner' ) );
	}


	/**
	 * Get Color Text Field
	 *
	 * @return Field
	 */
	public function get_color_text_field() {
		$palette = array_column(Swatches::get_colors(), 'color');
		return Field::make(
			'color',
			static::BLOCK_TEXT_COLOR,
			__( 'Call To Action Text Color', 'ncpr-diviner' )
		)
			->set_palette( $palette )
			->set_default_value( $palette[4] );
	}

	/**
	 * Get Color Text Hover Field
	 *
	 * @return mixed
	 */
	public function get_color_text_hover_field() {
		$palette = array_column(Swatches::get_colors(), 'color');
		return Field::make(
			'color',
			static::BLOCK_TEXT_COLOR_HOVER,
			__( 'Call To Action Text Hover Color', 'ncpr-diviner' )
		)
			->set_palette( $palette )
			->set_default_value( $palette[3] );
	}

	/**
	 * Get Color Field
	 *
	 * @return mixed
	 */
	public function get_color_field() {
		$palette = array_column(Swatches::get_colors(), 'color');
		return Field::make(
			'color',
			static::BLOCK_COLOR,
			__( 'Call To Action BG Color', 'ncpr-diviner' )
		)
			->set_palette( $palette )
			->set_default_value( $palette[0] );
	}

	/**
	 * Get Icon Field
	 *
	 * @return mixed
	 */
	public function get_icon_field() {
		$icons = new FontAwesome();
		$field = Field::make( 'select', static::BLOCK_ICON, __( 'Icon' ) );
		$icons_simplified = $icons->getReadableNames();
		array_unshift(
			$icons_simplified,
			''
		);
		$field->add_options($icons_simplified);
		$field->set_default_value('');
		return $field;
	}

	/**
	 * Custom Related Archive Items Block
	 */
	public function render( $block_data ) {
		$has_link = false;
		$has_manual_link = isset( $block_data[static::BLOCK_LINK] ) && !empty( $block_data[static::BLOCK_LINK] );
		$has_page_link = isset( $block_data[static::BLOCK_PAGE] ) && !empty( $block_data[static::BLOCK_PAGE] );

		if ($has_page_link || $has_manual_link ) {
			$has_link = true;
			$link = ( $has_page_link ) ? get_permalink( $block_data[static::BLOCK_PAGE] ) : esc_url( $block_data[static::BLOCK_LINK] );
		}

		$block_class = uniqid('diviner-block__call-to-action-');
		ob_start();
		if ( $has_link ) {
			if ( isset( $block_data[static::BLOCK_TEXT_COLOR] )) {
				$text_color = $block_data[static::BLOCK_TEXT_COLOR];
				printf(
					'<style>.%s .call-to-action__link { color: %s;}</style>',
					$block_class,
					$text_color
				);
			}
			if ( isset( $block_data[static::BLOCK_TEXT_COLOR_HOVER] )) {
				$text_color_hover = $block_data[static::BLOCK_TEXT_COLOR_HOVER];
				printf(
					'<style>.%1$s .call-to-action__link:hover, .%1$s .call-to-action__link:focus { color: %2$s;}</style>',
					$block_class,
					$text_color_hover
				);
			}

			printf(
				'<a class="call-to-action__link" href="%s">',
				$link
			);
		}
		echo ('<div class="call-to-action__inner">');
		if ( isset( $block_data[static::BLOCK_BG_IMG] ) && !empty( $block_data[static::BLOCK_BG_IMG] ) ) {
			$image_src = wp_get_attachment_image_src( $block_data[static::BLOCK_BG_IMG], 'medium' );
			printf(
				'<div class="call-to-action__img" style="background-image: url(%s)"></div>',
				esc_attr($image_src[0])
			);
		}
		printf('<div class="call-to-action__color" style="background-color: %s"></div>',
			esc_attr($block_data[static::BLOCK_COLOR])
		);
		echo '<div class="call-to-action__content">';
		if ( isset( $block_data[static::BLOCK_ICON] ) && !empty( $block_data[static::BLOCK_ICON] ) ) {
			printf('<i class="call-to-action__icon fa %s" aria-hidden="true"></i>',
				esc_attr($block_data[static::BLOCK_ICON])
			);
		}
		if ( isset( $block_data[static::BLOCK_TITLE] ) && !empty( $block_data[static::BLOCK_TITLE] ) ) {
			printf('<div class="call-to-action__title h3">%s</div>',
				esc_html($block_data[static::BLOCK_TITLE])
			);
		}
		if ( isset( $block_data[static::BLOCK_SUBTITLE] ) && !empty( $block_data[static::BLOCK_SUBTITLE] ) ) {
			printf('<div class="call-to-action__subtitle">%s</div>',
				esc_html($block_data[static::BLOCK_SUBTITLE])
			);
		}
		echo '</div>';
		echo '</div>';
		if ( $has_link ) {
			echo '</a>';
		}
		$output = ob_get_clean();

		printf(
			'<div class="diviner-block diviner-block__call-to-action %s">%s</div>',
			$block_class,
			$output
		);
	}

}
