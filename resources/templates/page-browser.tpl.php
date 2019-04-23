
<?php get_header(); ?>

<?php
    /**
     * Functions hooked into `theme/header` action.
     *
     * @hooked Tonik\Theme\Index\render_header - 10
     */
    do_action('theme/header');
?>

<div class="main__inner">

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

	<div id="browse-app" class="browse-app"></div>
</div>

<?php get_footer(); ?>
