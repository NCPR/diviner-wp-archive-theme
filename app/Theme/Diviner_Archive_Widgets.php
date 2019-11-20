<?php

namespace Diviner_Archive\Theme;

use function Diviner_Archive\Helpers\diviner_archive_template;

/**
 * Class Widgets
 *
 * Functions Theme
 *
 * @package Diviner_Archive\Theme
 */
class Diviner_Archive_Widgets {

	const SIDEBAR_ID_AFTER_TITLE = 'sidebar_after_title';
	const SIDEBAR_ID_RIGHT = 'sidebar_right';
	const SIDEBAR_ID_FOOTER_1 = 'sidebar_footer_1';
	const SIDEBAR_ID_FOOTER_2 = 'sidebar_footer_2';
	const SIDEBAR_ID_404 = 'sidebar_404';


	public function hooks() {
		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		add_action( 'widgets_init', [ $this, 'load_widgets' ] );
		add_action( 'theme/header/after-title', [$this, 'after_title']);
		add_action( 'theme/above-content', [$this, 'above_content']);
	}

	function load_widgets() {

	}

	function register_sidebars() {
		register_sidebar([
			'id'           => static::SIDEBAR_ID_RIGHT,
			'name'         => __('Sidebar Widget Area for One Column Template', 'diviner-archive'),
			'description'  => __( 'Add widgets here to appear in the One Column with Sidebar Template sidebar. If empty, the content is displayed as full width', 'diviner-archive' ),
			'before_title' => '<h5 class="h5">',
			'after_title'  => '</h5>',
		]);

		register_sidebar([
			'id'           => static::SIDEBAR_ID_AFTER_TITLE,
			'name'         => __('After Single Title Widget Area', 'diviner-archive'),
			'description'  => __('Add widgets to widget area after single and page titles. Does not appear on homepage. If empty, nothing appears', 'diviner-archive'),
			'before_title' => '<div class="a11y-hidden">',
			'after_title' => '</div>',
		]);

		register_sidebar([
			'id'           => static::SIDEBAR_ID_FOOTER_1,
			'name'         => __('Footer Widget Area 1', 'diviner-archive'),
			'description'  => __('Add widgets to the left foot widget area. If empty, nothing appears', 'diviner-archive'),
			'before_title' => '<div class="a11y-hidden">',
			'after_title' => '</div>',
		]);

		register_sidebar([
			'id'           => static::SIDEBAR_ID_FOOTER_2,
			'name'         => __('Footer Widget Area 2', 'diviner-archive'),
			'description'  => __('Add widgets to the right foot widget area. If empty, nothing appears', 'diviner-archive'),
			'before_title' => '<div class="a11y-hidden">',
			'after_title' => '</div>',
		]);

		register_sidebar([
			'id'           => static::SIDEBAR_ID_404,
			'name'         => __('404 Widget Area', 'diviner-archive'),
			'description'  => __('Add widgets to the 404 widget area. If empty, nothing appears', 'diviner-archive'),
			'before_title' => '<div class="h3">',
			'after_title' => '</div>',
		]);

	}

	function after_title() {
		if (!is_front_page()) {
			static::render_sidebar(static::SIDEBAR_ID_AFTER_TITLE);
		}
	}

	function above_content() {
		if (is_page_template('template-sidebar.php')) {
			static::render_sidebar(static::SIDEBAR_ID_RIGHT);
		}
	}

	static public function get_sidebar( $id ) {
		ob_start();
		static::render_sidebar($id);
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * Renders sidebar
	 *
	 */
	static function render_sidebar( $id ) {
		$path = sprintf(
			'partials/sidebar--$s',
			$id
		);
		try {
			diviner_archive_template($path);
		} catch (\Exception $e) {
			if ( is_active_sidebar( $id ) ) {
				$sidebar_class = sprintf(
					'sidebar--%s',
					esc_attr( $id )
				);
				?>
				<aside class="sidebar <?php echo esc_attr( $sidebar_class ); ?>">
					<div class="sidebar__content">
						<ul class="sidebar__list">
							<?php dynamic_sidebar( $id ); ?>
						</ul>
					</div>
				</aside>
			<?php }
		}
	}

}
