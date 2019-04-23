<article class="single-item single-item--post">

	<header class="single-item__header">

		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>

		<div class="single-item__header-meta">
			<time class="single-item__header-time">
				<?php the_date(); ?>
			</time>
			<div class="single-item__header-categories">
				<?php the_category( ' | ' ); ?>
			</div>
		</div>

	</header>


	<div class="single-item__layout">

		<?php
		do_action('theme/before-content');
		?>

		<div class="d-content">
			<?php the_content(); ?>
		</div>

	</div>

	<?php
	do_action('theme/comments');
	?>

</article>
