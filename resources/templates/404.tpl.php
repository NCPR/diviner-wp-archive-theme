<?php
use Diviner\Theme\General;
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
					<h1 class="single-item__header-title h1"><?php echo __( 'Not Found', 'ncpr-diviner' ); ?></h1>
				</header>

				<div class="single-item__layout">

					<div class="d-content">
						<p><?php echo __( 'The page you are looking for does not exist.', 'ncpr-diviner' ); ?></p>
					</div>

					<div class="section">
						<?php get_search_form(); ?>
					</div>


				</div>

			</article>

		</div>
	</div>

</div>

<?php get_footer(); ?>
