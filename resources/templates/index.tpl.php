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

	<div class="wrapper">
		<div class="wrapper__inner">
			<div class="<?php echo General::get_loop_classes(); ?>">

				<h1 class="h1 <?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?>">
					<?php echo General::get_page_title(); ?>
				</h1>

				<?php
				/**
				 * Functions hooked into `theme/index/under-page-title` action.
				 *
				 */
					do_action('theme/index/under-page-title');
				?>

				<?php if (have_posts()) : ?>

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

				<?php else : ?>
					<?php
					/**
					 * Functions hooked into `theme/index/content/none` action.
					 *
					 * @hooked Tonik\Theme\App\Structure\render_empty_content - 10
					 */
					do_action('theme/index/content/none');
					?>
				<?php endif; ?>

			</div>

		</div>
	</div>

</div>

<?php get_footer(); ?>
