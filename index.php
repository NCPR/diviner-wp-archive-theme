<?php

namespace Tonik\Theme\Index;

/*
|------------------------------------------------------------------
| Index Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function Tonik\Theme\App\template;

/**
 * Renders index page header.
 *
 * @see resources/templates/index.tpl.php
 */
function render_header()
{
	template('partials/header', [
		'brand' => \Diviner\Theme\General::the_header_brand(),
		'lead'  => get_bloginfo( 'description' ),
		'primary_menu' => \Diviner\Theme\General::the_primary_menu(),
	]);
}
add_action('theme/index/header', 'Tonik\Theme\Index\render_header');

/**
 * Renders index page.
 *
 * @see resources/templates/index.tpl.php
 */
template('index');
