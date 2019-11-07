<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<a href="#a11y-skip-link-content" class="a11y-skip-link a11y-visual-hide"><?php echo esc_html__( 'Skip to main content', 'diviner-archive'); ?></a>
		<main id="app" class="main">
