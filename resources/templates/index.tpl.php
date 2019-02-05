<?php
use Diviner\Admin\Customizer;
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

	<div class="<?php echo General::get_wrapper_classes(); ?>">
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

			<?php if (apply_filters('theme/sidebar/visibility', true)) : ?>
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

</div>

<?php get_footer(); ?>
