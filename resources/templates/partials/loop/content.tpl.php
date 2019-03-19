<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;

?>
<article class="loop-item">

	<div class="loop-item__inner">

		<?php
		if ( get_post_thumbnail_id() ) {
			?>
			<div class="loop-item__feature-image">
				<a href="<?php the_permalink(); ?>">
				<?php
				Image::image(
					get_post_thumbnail_id(),
					General::IMAGE_SIZE_THUMBNAIL_SM,
					General::IMAGE_SIZE_THUMBNAIL_LRG,
					true,
					'(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w'
				);
				?>
				</a>
			</div>
			<?php
		}
		?>

		<div class="loop-item__content">
			<a href="<?php the_permalink(); ?>">
				<h2 class="h2"><?php the_title(); ?></h2>
			</a>
			<div class="loop-item__meta">
				<time class="loop-item__date">
					<?php the_date(); ?>
				</time>
			</div>

			<div class="loop-item__excerpt d-content">
				<?php the_excerpt(); ?>
			</div>
		</div>

	</div>

</article>
