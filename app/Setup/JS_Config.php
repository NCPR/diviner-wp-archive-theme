<?php

namespace Diviner\Setup;

class JS_Config {

	private $data;

	public function get_data() {
		if ( !isset( $this->data ) ) {
			$container = \Tonik\Theme\App\Main::instance()->container();
			$browse = $container[ 'theme.browse_page' ];
			$browse_page = $browse->get_current_browse_page();
			$is_current_browse = $browse->is_current_page_browse();
			$browse_page_id = $is_current_browse ? get_the_ID() : $browse_page;
			$content = get_post_field('post_content', $browse_page_id );
			$content = apply_filters( 'the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$permalink = get_permalink( $browse_page_id );
				$this->data = [
				'base_browse_url' => '/' . basename( $permalink ),
				'browse_page_title' => get_the_title( $browse_page_id ),
				'browse_page_content' => $content,
			];
			$this->data = apply_filters( 'diviner_js_config', $this->data );
		}

		return $this->data;
	}
}