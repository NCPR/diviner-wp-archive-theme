<?php

use \Diviner_Archive\Theme\Diviner_Archive_Image;
use \Diviner_Archive\Config\Diviner_Archive_General;

?>
<article class="loop-item <?php if (is_sticky()) { echo 'loop-item--sticky'; } ?>">

	<div class="loop-item__inner">

		<?php
		if ( get_post_thumbnail_id() ) {
			?>
			<div class="loop-item__feature-image">
				<a href="<?php the_permalink(); ?>">
				<?php
				Diviner_Archive_Image::image(
					get_post_thumbnail_id(),
					Diviner_Archive_General::IMAGE_SIZE_THUMBNAIL_SM,
					Diviner_Archive_General::IMAGE_SIZE_THUMBNAIL_LRG,
					true
				);
				?>
				</a>
			</div>
			<?php
		}
		?>

		<div class="loop-item__content">
			<a href="<?php the_permalink(); ?>">
				<h2 class="loop-item__title h3">
					<?php the_title(); ?>
				</h2>
			</a>
			<?php if (get_post_type() === 'post') { ?>
			<div class="loop-item__meta">
				<time class="loop-item__date">
					<?php the_time( get_option( 'date_format' ) ); ?>
				</time>
			</div>
			<?php } ?>

			<div class="loop-item__excerpt d-content">
				<?php the_excerpt(); ?>
			</div>
		</div>

	</div>

</article>
