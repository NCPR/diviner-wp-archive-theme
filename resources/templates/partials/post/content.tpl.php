<article class="single article">

	<header class="single__header">
		<h1 class="single__header-title h1"><?php the_title(); ?></h1>

		<time>
			<small><?php the_date(); ?></small>
		</time>
	</header>

	<div class="d-content">
		<p><?php the_content(); ?></p>
	</div>

</article>
