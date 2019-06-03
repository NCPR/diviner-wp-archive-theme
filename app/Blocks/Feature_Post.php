<?php

namespace Diviner\Blocks;

use function Tonik\Theme\App\template;
use Carbon_Fields\Block;
use Carbon_Fields\Field;

/**
 * Feature Post
 *
 * @package Diviner\Admin\Blocks
 */
class Feature_Post {

	const BLOCK_ID = 'diviner_block_fp';
	const BLOCK_TITLE = 'diviner_block_fp_title';
	const BLOCK_POST = 'diviner_block_fp_post';

	/**
	 * Custom Related Archive Items Block
	 */
	public function __construct() {
		Block::make( static::BLOCK_ID, __( 'Diviner Feature Post', 'ncpr-diviner' ) )
			->add_fields( [
				Field::make( 'text', static::BLOCK_TITLE, __( 'Block Title', 'ncpr-diviner' ) )->set_default_value( __( 'Feature Story', 'ncpr-diviner' ) ),
				Field::make( 'association', static::BLOCK_POST, __( 'Select Post To Display', 'ncpr-diviner' ) )
					->set_types( array(
						array(
							'type' => 'post',
							'post_type' => 'post',
						),
					) )
					->set_max( 1 )
			])
		->set_icon( 'star-filled' )
		->set_render_callback([ $this, 'render' ]); // ToDo figure out typecasting
	}

	/**
	 * Custom Related Archive Items Block
	 */
	public function render( $block_data ) {
		if ( !isset($block_data[static::BLOCK_POST]) || !isset($block_data[static::BLOCK_POST][0]) ) {
			return;
		}
		$args = [
			'p'         => $block_data[static::BLOCK_POST][0]['id'],
			'post_type' => 'post'
		];
		$feature_query = new \WP_Query($args);
		$output = '';
		if ( $feature_query->have_posts() ) {
			while ( $feature_query->have_posts() ) {
				$feature_query->the_post();
				ob_start();
				echo '<div class="feature-post__inner">';
				template('partials/loop/content', []);
				echo '</div>';
				$output = ob_get_clean();
			}
			wp_reset_postdata();
		}

		// displays nothing if there is no feature post
		if ( !empty( $output ) ) {
			$header = '';
			if ( isset( $block_data[static::BLOCK_TITLE] ) && !empty( $block_data[static::BLOCK_TITLE] ) ) {
				$header = sprintf('<h3 class="h3">%s</h3>',
					esc_html($block_data[static::BLOCK_TITLE])
				);
			}
			printf(
				'<div class="diviner-block diviner-block__feature-post">%s%s</div>',
				$header,
				$output
			);
		}
	}

}
