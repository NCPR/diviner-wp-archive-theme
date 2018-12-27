
<?php get_header(); ?>

<?php
    /**
     * Functions hooked into `theme/index/header` action.
     *
     * @hooked Tonik\Theme\Index\render_header - 10
     */
    do_action('theme/header');
?>


<section class="section">
	<div id="browse-app"></div>
</section>

<?php get_footer(); ?>
