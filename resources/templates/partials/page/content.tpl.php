<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="single-item__header">
		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>
	</header>

	<?php if( '' !== get_post()->post_content ) { ?>
	<div class="single-item__layout">

		<?php
		do_action('theme/above-content');
		?>

		<div class="d-content">

			<?php
			do_action('theme/before-content');
			?>

			<?php the_content(); ?>
		</div>

	</div>
	<?php } ?>

	<?php
	do_action('theme/article-end');
	?>

</article>
