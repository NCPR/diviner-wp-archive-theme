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
				esc_url( get_permalink( $searchpage ) ),
				esc_html__( 'Search', 'diviner-archive')
			);
			?>
			<?php
		}
	}

}
