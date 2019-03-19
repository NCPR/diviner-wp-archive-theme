<?php

namespace Diviner\Theme\Widgets;

use function Tonik\Theme\App\template;
use Carbon_Fields\Widget;
use Carbon_Fields\Field;
use Diviner\Post_Types\Archive_Item\Archive_Item;
use Diviner\Post_Types\Archive_Item\Post_Meta as ArchiveItemPostMeta;
use Diviner\Admin\Settings;
use Diviner\Theme\General;

class Widget_Related_Items extends Widget {

	const DIVINER_WIDGET_RELATED_ITEMS = 'diviner_widget_related_items';
	const DIVINER_WIDGET_RELATED_FIELD_TITLE = 'diviner_widget_related_field_title';

	/**
	 * Register widget function. Must have the same name as the class
	 *
	 */
	function __construct() {
		$this->setup(
			static::DIVINER_WIDGET_RELATED_ITEMS,
			__( 'Diviner Theme Widget - Related Items', 'ncpr-diviner' ),
			__( 'Displays a slider of related items. Must be added to an Archive Item', 'ncpr-diviner' ),
			array(
				Field::make(
					'text',
					static::DIVINER_WIDGET_RELATED_FIELD_TITLE,
					__( 'Title', 'ncpr-diviner' )
				)->set_default_value( 'Related Items') ,
			)
		);
	}

	/**
	 * Constructs markup for slider cards as an array
	 *
	 * array(4) {
			["value"]=>
				string(29) "post:diviner_archive_item:183"
			["type"]=>
				string(4) "post"
			["subtype"]=>
				string(20) "diviner_archive_item"
			["id"]=>
				string(3) "183"
		}
	 *
	 */
	function get_related_cards() {
		$post_id = get_the_ID();
		$related_items = carbon_get_post_meta($post_id, ArchiveItemPostMeta::FIELD_RELATED);
		$related_ids = array_map(function($related_item) {
			return $related_item['id'];
		}, $related_items);
		$args = [
			'posts_per_page' => -1,
			'orderby' => 'modified',
			'post__in' => $related_ids,
			'post__not_in' => [$post_id],
			'post_type' => Archive_Item::NAME
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
		} else {
			// no output
		}
		return $related_post_output;
	}

	/**
	 * Called when rendering the widget in the front-end
	 *
	 */
	function front_end( $args, $instance ) {
		if (get_post_type() !== Archive_Item::NAME ) {
			return false;
		}
		$show_related = carbon_get_theme_option(Settings::FIELD_GENERAL_RELATED_FIELD);
		if (!$show_related) {
			return false;
		}

		// display only  if we have related items
		$related = $this->get_related_cards();
		if (empty($related)) {
			return false;
		}
		printf('%s%s%s',
			$args['before_title'],
			$instance[static::DIVINER_WIDGET_RELATED_FIELD_TITLE],
			$args['after_title']
		);

		ob_start();
		template('partials/slider', [
			'slides' => implode('', $related),
			'swiper_data' => json_encode([
				'autoHeight' => true
			])
		]);
		$output = ob_get_clean();

		printf(
			'<div class="widget-related__slider">%s</div>',
			$output
		);
	}

}

