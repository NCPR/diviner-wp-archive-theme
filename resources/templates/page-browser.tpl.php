
<?php get_header(); ?>

<?php
    /**
     * Functions hooked into `theme/index/header` action.
     *
     * @hooked Tonik\Theme\Index\render_header - 10
     */
    do_action('theme/header');
?>

<div class="main__inner">

	<section class="section">
		<div id="browse-app" class="browse-app"></div>
	</section>

</div>

<?php get_footer(); ?>
