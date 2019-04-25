<article class="single-item single-item--page">

	<header class="single-item__header">
		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>
	</header>

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

	<?php
	do_action('theme/article-end');
	?>

</article>
