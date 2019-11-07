<article class="single-item single-item--page">

	<header class="single-item__header">
		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title">
			<?php the_title(); ?>
		</h1>
		<?php
		do_action('theme/header/after-title');
		?>
	</header>

	<?php if ( !empty( get_the_content() ) ) { ?>
		<div class="single-item__block single-item__block--tight">

			<div class="d-content">

				<?php
				do_action('theme/before-content');
				?>

				<?php the_content(); ?>
			</div>

		</div>
	<?php } ?>

	<div class="single-item__block">
		<?php get_search_form(); ?>
	</div>

</article>