<?php

$show_widget_area = !empty( $widget_area_404 );

?>
<?php get_header(); ?>
<?php
/**
 * Functions hooked into `theme/header` action.
 *
 */
do_action('theme/header');
?>
<div class="main__inner">

	<div class="wrapper">

		<div class="wrapper__inner">

			<article class="single-item single-item--page">

				<header class="single-item__header">
					<h1 class="single-item__header-title h1"><?php echo __( 'Not Found', 'diviner-archive' ); ?></h1>
				</header>

				<div class="single-item__layout">

					<div class="d-content">
						<p><?php echo __( 'The page you are looking for does not exist.', 'diviner-archive' ); ?></p>
					</div>

					<?php
					if (!empty($show_widget_area)) {
						printf(
								'<div class="section">%s</div>',
							$widget_area_404
						);
					}
					?>

				</div>

			</article>

		</div>
	</div>

</div>

<?php get_footer(); ?>
