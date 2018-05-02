<?php

namespace Tonik\Theme\App\Setup;

/*
|-----------------------------------------------------------
| Theme Actions
|-----------------------------------------------------------
|
| This file purpose is to include your custom
| actions hooks, which process a various
| logic at specific parts of WordPress.
|
*/

/**
 * Example action handler.
 *
 * @return integer
 */
function example_action()
{
    //
}
add_filter('excerpt_length', 'Tonik\Theme\App\Setup\example_action');

/**
 * Display notice when plugin is not installed.
 *
 * @return integer
 */
function plugin_check() {
	if ( ! is_plugin_active( 'diviner-wp-archive-plugin/diviner-wp-archive-plugin.php' ) ){
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e('The Diviner Archive Theme requires the diviner-wp-archive-plugin Plugin', 'shapeSpace'); ?></p>
		</div>
		<?php
	}
}
add_action('admin_notices', 'Tonik\Theme\App\Setup\plugin_check');


/*
 *
 *
 */
