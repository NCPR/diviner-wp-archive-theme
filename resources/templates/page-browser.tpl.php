
<?php get_header(); ?>

<?php
    /**
     * Functions hooked into `theme/index/header` action.
     *
     * @hooked Tonik\Theme\Index\render_header - 10
     */
    do_action('theme/index/header');
?>


<section class="section">
	<div class="wrapper">
		<div class="content">
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

		<div id="browse-app"></div>

	</div>
</section>


<?php get_footer(); ?>
