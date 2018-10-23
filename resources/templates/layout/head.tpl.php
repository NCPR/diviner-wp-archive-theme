<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <main id="app" class="app">
			<header>
				<h1>
					<a href="<?= get_home_url(); ?>">Diviner</a>
				</h1>

				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>

			</header>
