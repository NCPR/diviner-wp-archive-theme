<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="single-item__header">

		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>

		<div class="single-item__header-meta">
			<time class="single-item__header-date">
				<?php the_time( get_option( 'date_format' ) ); ?>
			</time>
			<div class="single-item__header-categories">
				<?php the_category( ' | ' ); ?>
			</div>
			<div class="single-item__header-tags">
				<?php the_tags(); ?>
			</div>
		</div>

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
