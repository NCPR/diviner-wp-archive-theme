<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;

// defaults
$display_excerpt = isset($display_excerpt) ? $display_excerpt : true;
$display_feature = isset($display_feature) ? $display_feature : true;

?>

<article class="card">

	<div class="card__inner">

		<?php
		if ( $display_feature && get_post_thumbnail_id() ) {
		?>
			<a href="<?php the_permalink(); ?>">
			<div class="card__feature-image">
				<?php
				Image::image(
					get_post_thumbnail_id(),
					General::IMAGE_SIZE_CARD_SM,
					General::IMAGE_SIZE_CARD_LRG,
					false,
					'(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w'
				);
				?>
			</div>
			</a>
		<?php
		}
		?>

		<div class="card__title h6">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</div>

		<!-- ToDo: display the categories conditionally or the date -->

		<?php if ( $display_excerpt ) {
			printf(
				'<div class="card__excerpt d-content"><p>%s</p></div>',
				get_the_excerpt()
			);
		} ?>
	</div>

</article>
