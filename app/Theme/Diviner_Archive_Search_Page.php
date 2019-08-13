<?php


namespace Diviner_Archive\Theme;

use \Diviner_Archive\Admin\Diviner_Archive_Customizer;

/**
 * Setting up the Browse page at startup
 *
 * @package Diviner_Archive\Admin
 */
class Diviner_Archive_Search_Page {

	public function hooks() {
		add_action( 'theme/header/end', [ $this, 'action_header_end' ]);
	}

	/**
	 * Action to output the search icon
	 *
	 */
	public function action_header_end() {
		$searchpage = get_theme_mod(Diviner_Archive_Customizer::SECTION_THEME_SETTING_SEARCH_PAGE );
		if ( !empty( $searchpage ) ) {
			printf(
				'<a class="header__menu-search" href="%s"><span class="fas fa-search" aria-hidden="true"></span><div class="a11y-hidden">%s</div></a>',
				get_permalink( $searchpage ),
				__( 'Search', 'diviner-archive')
			);
			?>
			<?php
		}
	}

	/**
	 * Gets first page with the search template
	 *
	 * @return int post id
	 */
	public function get_current_search_page() {
		$args = [
			'posts_per_page' => -1,
			'fields' => 'ids',
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-search.php'
		];
		$current_search_pages = get_posts($args);
		if ( is_array( $current_search_pages ) && count( $current_search_pages ) > 0 ) {
			return $current_search_pages[0];
		}
		return 0;
	}
}
