<?php

namespace Diviner\Blocks;

use function Tonik\Theme\App\template;
use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Diviner\Post_Types\Archive_Item\Archive_Item;

/**
 * Recent Archive Items
 *
 * @package Diviner\Admin\Blocks
 */
class Recent_Archive_Items {

	const BLOCK_TITLE = 'diviner_block_rai_title';

	/**
	 * Custom Related Archive Items Block
	 */
	public function init() {
		Block::make( 'Recent Archive Items' )
			->add_fields( [
				Field::make( 'text', static::BLOCK_TITLE, __( 'Block Title', 'ncpr-diviner' ) )->set_default_value( __( 'Recent Archive Items', 'ncpr-diviner' ) )
			])
		->set_render_callback([ $this, 'render' ]); // ToDo figure out typecasting
	}

	/**
	 * Custom Related Archive Items Block
	 */
	public function render( $recent_items ) {
		$args = [
			'posts_per_page' => 25,
			'post_type' => Archive_Item::NAME,
			'category' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
		];
		$related_query = new \WP_Query($args);
		$related_post_output = [];
		if ( $related_query->have_posts() ) {
			while ( $related_query->have_posts() ) {
				$related_query->the_post();
				ob_start();
				echo '<div class="swiper-slide">';
				template('partials/loop/card', [
					'display_excerpt' => false
				]);
				echo '</div>';
				$output = ob_get_clean();
				$related_post_output[] = $output;
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		$output = '';
		if ( count($related_post_output) ) {
			ob_start();
			template('partials/slider', [
				'slides' => implode('', $related_post_output),
				'swiper_data' => json_encode([
					'autoHeight' => true
				])
			]);
			$output = ob_get_clean();
		} else {
			$output = sprintf('<p>%s</p>',
				__( 'No recent archive items found', 'ncpr-diviner' )
			);
		}
		$header = '';
		if ( isset( $recent_items[static::BLOCK_TITLE] ) && !empty( $recent_items[static::BLOCK_TITLE] ) ) {
			$header = sprintf('<h3 class="h3">%s</h3>',
				esc_html($recent_items[static::BLOCK_TITLE])
			);
		}
		printf(
			'<div class="diviner-block diviner-block_recent-items">%s%s</div>',
			$header,
			$output
		);
	}

}
