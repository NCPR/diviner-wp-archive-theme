<article class="single-item single-item--page">

	<header class="single-item__header">
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
	</header>

	<?php if ( !empty( get_the_content() ) ) { ?>
		<div class="single-item__block single-item__block--tight">

			<div class="d-content">
				<?php the_content(); ?>
			</div>

		</div>
	<?php } ?>

	<div class="single-item__block">
		<?php get_search_form(); ?>
	</div>

</article>