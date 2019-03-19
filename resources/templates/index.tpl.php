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
				<div class="loop loop--<?php echo get_post_type();?>">
					<h1 class="h1 <?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?> page-title">
						<?php echo \Diviner\Theme\General::get_page_title(); ?>
					</h1>
					<div class="loop__posts">
						<?php while (have_posts()) : the_post() ?>
							<?php
							/**
							 * Functions hooked into `theme/index/content` action.
							 *
							 */
							do_action('theme/index/content');
							?>
						<?php endwhile; ?>
					</div>

					<?php Diviner\Theme\Pagination::pagination(); ?>

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

		</div>
	</div>

</div>

<?php get_footer(); ?>
