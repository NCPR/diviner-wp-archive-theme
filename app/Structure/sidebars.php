<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Sidebars
|-----------------------------------------------------------
|
| This file is for registering your theme sidebars,
| Creates widgetized areas, which an administrator
| of the site can customize and assign widgets.
|
*/

use \Diviner\Theme\General;

/**
 * Registers the widget areas.
 *
 * @return void
 */
function register_widget_areas()
{
    register_sidebar([
        'id'           => General::SIDEBAR_RIGHT_ID,
        'name'         => __('Sidebar', 'ncpr-diviner'),
        'description'  => __('Website sidebar', 'ncpr-diviner'),
        'before_title' => '<h5>',
        'after_title'  => '</h5>',
    ]);
}
add_action('widgets_init', 'Tonik\Theme\App\Structure\register_widget_areas');
