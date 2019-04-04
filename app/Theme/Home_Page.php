<?php


namespace Diviner\Theme;

/**
 * Setting up the home page at startup
 *
 * @package Diviner\Admin
 */
class Home_Page {

	const THEME_OPTION_HOME_PAGE_CREATED = 'diviner_theme_option_homepage_created';

	public function hooks() {
		if ( DIVINER_IS_THEME ) {
			add_action( 'after_switch_theme', [ $this, 'setup_home_page' ] );
		}
	}

	/**
	 * Check to verify that a page is a browse page
	 *
	 * @return boolean
	 */
	public function is_current_page_browse() {
		return is_page_template('page-browser.php');
	}

	/**
	 * Gets first page with the browse template
	 *
	 * @return int post id
	 */
	public function get_current_browse_page() {
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-browser.php'
		];
		$current_browse_pages = get_posts($args);
		if ( is_array($current_browse_pages) && count( $current_browse_pages ) > 0 ) {
			return $current_browse_pages[0];
		}
		return 0;
	}

	/**
	 * do we have a browse page
	 */
	public function already_have_browse_page() {
		$current_browse_page = $this->get_current_browse_page();
		return isset( $current_browse_page ) && $current_browse_page > 0;
	}

	public function get_content() {
		ob_start();
		?>
		<!-- wp:paragraph -->
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non posuere nisi. Nullam euismod mi nisi, nec ullamcorper felis rhoncus eu. Vestibulum gravida vehicula ex at mattis. </p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph -->
		<p>Donec lacus quam, lacinia at nulla ac, egestas pellentesque justo. Vestibulum orci nulla, pellentesque vel lacus a, feugiat sodales ex. Nullam at pulvinar metus, ac maximus odio. Phasellus iaculis pretium pulvinar. Mauris turpis nulla, consequat vitae mattis eu, mollis ut orci.&nbsp;</p>
		<!-- /wp:paragraph -->

		<!-- wp:columns {"columns":3,"align":"wide"} -->
		<div class="wp-block-columns alignwide has-3-columns"><!-- wp:column -->
			<div class="wp-block-column"><!-- wp:carbon-fields/diviner-block-cta {"data":{"diviner_block_cta_title":"Promo Title 1","diviner_block_cta_color":"#F4D35E","diviner_block_cta_text_color":"#000000","diviner_block_cta_text_color_hover":"#0D3B66","diviner_block_cta_bg_img":"","diviner_block_cta_icon":"fa-magnet","diviner_block_cta_link":"#","diviner_block_cta_subtitle":"More info here"}} /--></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:carbon-fields/diviner-block-cta {"data":{"diviner_block_cta_title":"Promo Title 2","diviner_block_cta_color":"#F4D35E","diviner_block_cta_bg_img":"","diviner_block_cta_icon":"fa-headphones","diviner_block_cta_link":"#","diviner_block_cta_subtitle":"Some subtitle","diviner_block_cta_text_color":"#000000","diviner_block_cta_text_color_hover":"#0D3B66"}} /--></div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column"><!-- wp:carbon-fields/diviner-block-cta {"data":{"diviner_block_cta_title":"Promo Title 3 ","diviner_block_cta_color":"#F4D35E","diviner_block_cta_text_color":"#000000","diviner_block_cta_text_color_hover":"#0D3B66","diviner_block_cta_bg_img":"","diviner_block_cta_icon":"fa-heart","diviner_block_cta_link":"#","diviner_block_cta_subtitle":"Another subtitle"}} /--></div>
			<!-- /wp:column --></div>
		<!-- /wp:columns -->

		<!-- wp:carbon-fields/diviner-block-fp {"data":{"diviner_block_fp_title":"Feature Story","diviner_block_fp_post":[{"id":1,"type":"post","subtype":"post"}]}} /-->

		<!-- wp:carbon-fields/diviner-block-rai /-->
		<?php
		return ob_get_clean();
	}

	/**
	 * Create Home page
	 */
	public function create_home_page() {
		// Create post object
		$browse_page = array(
			'post_title'    => wp_strip_all_tags( __( 'Diviner Home', 'ncpr-diviner' ) ),
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_content'  => $this->get_content(),
			'post_type'     => 'page',
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		);

		// Insert the post into the database
		return wp_insert_post( $browse_page );
	}

	/**
	 * Init Home page
	 */
	public function setup_home_page() {
		$homepage_exists = get_option( static::THEME_OPTION_HOME_PAGE_CREATED, 0 );
		if (!$homepage_exists) {
			$page_id = $this->create_home_page();
			if($page_id !== 0) {
				update_option( 'page_on_front', $page_id);
				update_option( 'show_on_front', 'page' );
				update_option( static::THEME_OPTION_HOME_PAGE_CREATED, 1 );
			}

		}
	}

}
