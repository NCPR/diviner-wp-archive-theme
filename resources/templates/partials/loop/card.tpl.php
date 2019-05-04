<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;
use \Diviner\Post_Types\Archive_Item\Archive_Item;

// defaults
$display_excerpt = isset($display_excerpt) ? $display_excerpt : true;
$display_feature = isset($display_feature) ? $display_feature : true;

$image_size_src = General::IMAGE_SIZE_CARD_SM;
$image_size_src_set = General::IMAGE_SIZE_CARD_LRG;

if ( get_post_type() === Archive_Item::NAME ) {
	$image_size_src = General::IMAGE_SIZE_BROWSE_GRID;
	$image_size_src_set = General::IMAGE_SIZE_BROWSE_GRID;
}

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
					$image_size_src,
					$image_size_src_set,
					false
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
