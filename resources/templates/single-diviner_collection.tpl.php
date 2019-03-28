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

		</div>
	</div>

</div>

<?php get_footer(); ?>

