<article class="article article--thumbnail">

	<div class="d-content">
		<a href="<?php the_permalink(); ?>">
			<h2><?php the_title(); ?></h2>
		</a>

		<time>
			<small>
				<?php the_time( get_option( 'date_format' ) ); ?>
			</small>
		</time>
	</div>

</article>
