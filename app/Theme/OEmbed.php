<?php


namespace Diviner\Theme;


class OEmbed{

	/**
	 * Add wrapper around embeds for admin visual editor styling
	 *
	 * @filter embed_oembed_html
	 */
	public function wrap_admin_oembed( $html, $url, $attr, $post_id ) {
		if ( ! is_admin() ) {
			return $html;
		}

		return sprintf( '<div class="wp-embed"><div class="wp-embed-wrap">%s</div></div>', $html );
	}

}
