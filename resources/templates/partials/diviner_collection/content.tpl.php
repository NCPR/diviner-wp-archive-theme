<?php

use Diviner\Post_Types\Collection\Collection;
use function Tonik\Theme\App\template;

?>
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

	<div class="single-item__layout single-item__block">

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

	<div class="single-item__block loop loop--cards">

		<h2 class="h2"><?php _e('Archive Items') ?></h2>

		<?php
		// the query
		$the_query = Collection::get_archive_items_query();
		?>

		<?php if ( $the_query->have_posts() ) : ?>

			<div class="loop__posts loop__posts--cards">
				<?php while ($the_query->have_posts()) : $the_query->the_post() ?>
					<?php
					template('partials/loop/card', []);
					?>
				<?php endwhile; ?>
			</div>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			<p><?php esc_html_e( 'Sorry, there are no archive items in ths collection.' ); ?></p>
		<?php endif; ?>


	</div>

	<?php
	do_action('theme/article-end');
	?>

</article>
