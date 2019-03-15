
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
	<div id="browse-app" class="browse-app"></div>
</div>

<?php get_footer(); ?>
