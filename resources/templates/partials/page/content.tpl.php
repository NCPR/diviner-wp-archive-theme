<article class="single-item single-item--page">

	<header class="single-item__header">
		<h1 class="single-item__header-title h1"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>
	</header>

	<div class="single-item__layout">

		<?php
		do_action('theme/before-content');
		?>

		<div class="d-content">
			<?php the_content(); ?>
		</div>

	</div>

</article>
