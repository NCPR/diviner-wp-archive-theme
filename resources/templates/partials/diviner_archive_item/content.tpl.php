<?php
use Diviner\Theme\General;
?>

<article class="single-item single-item--post">

	<header class="single-item__header">
		<h1 class="single-item__header-title h1"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>
		<?php
		do_action('theme/header/feature-image');
		?>
	</header>

	<aside class="sidebar sidebar--grey sidebar--pull-right">

		<div class="sidebar__content">

			<h5>Details</h5>

			<?php // output meta data
			General::the_archive_single_meta();
			?>

		</div>

	</aside>

	<div class="d-content">
		<p><?php the_content(); ?></p>
	</div>

</article>
