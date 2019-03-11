<article class="single-item single-item--post">

	<header class="single-item__header">
		<h1 class="single-item__header-title h1"><?php the_title(); ?></h1>

		<?php
		do_action('theme/header/after-title');
		?>

		<div class="single-item__header-meta">
			<time class="single-item__header-time">
				<?php the_date(); ?>
			</time>
		</div>

	</header>

	<div class="d-content">
		<p><?php the_content(); ?></p>
	</div>

</article>
