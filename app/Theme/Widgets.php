<?php

namespace Diviner\Theme;

use function Tonik\Theme\App\template;

/**
 * Class Widgets
 *
 * Functions Theme
 *
 * @package Diviner\Theme
 */
class Widgets {

	const SIDEBAR_ID_AFTER_TITLE = 'sidebar_after_title';
	const SIDEBAR_ID_RIGHT = 'sidebar_right';

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
			'name'         => __('Sidebar', 'diviner-archive'),
			'description'  => __('Website sidebar', 'diviner-archive'),
			'before_title' => '<h5 class="h5">',
			'after_title'  => '</h5>',
		]);

		register_sidebar([
			'id'           => static::SIDEBAR_ID_AFTER_TITLE,
			'name'         => __('After Single Title', 'diviner-archive'),
			'description'  => __('Displaying after single titles (ex: for social media widgets)', 'diviner-archive'),
			'before_title' => '<span class="a11y-hidden">',
			'after_title' => '</span>',
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

	static function render_sidebar($id) {
		$path = sprintf(
			'partials/sidebar--$s',
			$id
		);
		try {
			template($path);
		} catch (\Exception $e) {
			if ( is_active_sidebar( $id ) ) {
				$sidebar_class = sprintf(
					'sidebar--%s',
					esc_attr( $id )
				);
				?>
				<div class="sidebar <?php echo $sidebar_class; ?>">
					<div class="sidebar__content">
						<ul class="sidebar__list">
							<?php dynamic_sidebar( $id ); ?>
						</ul>
					</div>
				</div>
			<?php }
		}
	}

}
