<?php

use \Diviner_Archive\Theme\Diviner_Archive_Widgets;

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
					<h1 class="single-item__header-title h1"><?php esc_html__( 'Not Found', 'diviner-archive' ); ?></h1>
				</header>

				<div class="single-item__layout">

					<div class="d-content">
						<p><?php echo esc_html__( 'The page you are looking for does not exist.', 'diviner-archive' ); ?></p>
					</div>

					<?php
					if ( is_active_sidebar( Diviner_Archive_Widgets::SIDEBAR_ID_404 ) ) {
						?>
						<div class="section">
							<?php
							Diviner_Archive_Widgets::render_sidebar(Diviner_Archive_Widgets::SIDEBAR_ID_404 )
							?>
						</div>
						<?php
					}
					?>

				</div>

			</article>

		</div>
	</div>

</div>

<?php get_footer(); ?>
