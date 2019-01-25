<?php get_header(); ?>
<?php
use Diviner\Admin\Customizer;
?>
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
					<div class="loop">
						<h1 class="h1 <?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?>">Posts</h1>
						<div class="posts">
							<?php while (have_posts()) : the_post() ?>
								<?php
								/**
								 * Functions hooked into `theme/index/post/thumbnail` action.
								 *
								 * @hooked Tonik\Theme\App\Structure\render_post_thumbnail - 10
								 */
								do_action('theme/index/post/thumbnail');
								?>
							<?php endwhile; ?>
						</div>

					</div>

				<?php else : ?>
					<div class="loop">
						<?php
						/**
						 * Functions hooked into `theme/index/content/none` action.
						 *
						 * @hooked Tonik\Theme\App\Structure\render_empty_content - 10
						 */
						do_action('theme/index/content/none');
						?>
					</div>
				<?php endif; ?>

				<?php if (apply_filters('theme/index/sidebar/visibility', true)) : ?>
					<?php
					/**
					 * Functions hooked into `theme/index/sidebar` action.
					 *
					 * @hooked Tonik\Theme\App\Structure\render_sidebar - 10
					 */
					do_action('theme/index/sidebar');
					?>
				<?php endif; ?>

			</div>
		</div>
	</section>

</div>

<?php get_footer(); ?>
