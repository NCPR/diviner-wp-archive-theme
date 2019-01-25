<?php get_header(); ?>

<?php
/**
 * Functions hooked into `theme/header` action.
 *
 */
do_action('theme/header');
?>
<div class="main__inner">

	<section class="section">
		<div class="wrapper">
			<div class="wrapper__inner">

				<?php if (have_posts()) : ?>
					<?php while (have_posts()) : the_post() ?>

						<?php
						/**
						 * Functions hooked into `theme/single/content` action.
						 *
						 * @hooked Tonik\Theme\App\Structure\render_post_content - 10
						 */
						do_action('theme/single/content');
						?>
					<?php endwhile; ?>
				<?php endif; ?>

				<?php if (apply_filters('theme/single/sidebar/visibility', true)) : ?>
					<?php
					/**
					 * Functions hooked into `theme/single/sidebar` action.
					 *
					 * @hooked Tonik\Theme\App\Structure\render_sidebar - 10
					 */
					do_action('theme/single/sidebar');
					?>
				<?php endif; ?>

			</div>
		</div>
	</section>

</div>

<?php get_footer(); ?>
