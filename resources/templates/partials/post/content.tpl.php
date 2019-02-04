<article class="single single--post">

	<header class="single__header">
		<h1 class="single__header-title h1"><?php the_title(); ?></h1>

		<div class="single__header-meta">
			<time class="single__header-time">
				<?php the_date(); ?>
			</time>
		</div>

	</header>

	<div class="d-content">
		<p><?php the_content(); ?></p>
	</div>

</article>
