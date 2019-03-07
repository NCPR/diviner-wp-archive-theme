<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;
use \Diviner\Theme\Post_Meta;

$thumbnail_id = get_post_thumbnail_id();

if ( !isset( $thumbnail_id ) ) {
	return;
}

$title = carbon_get_post_meta( get_the_ID(), Post_Meta::FIELD_SUBHEADER_TEXT );
$is_bg = ( isset( $title ) && !empty( $title ) );

?>
<div class="subheader">
	<?php if ( !$is_bg ) { ?>
		<div class="subheader__image">
			<?php Image::image(
					get_post_thumbnail_id(),
					General::IMAGE_SIZE_FEATURE_SM,
					General::IMAGE_SIZE_FEATURE_LRG,
					true,
					'(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w'
			); ?>
		</div>
	<?php } else { ?>
		<div class="subheader__image subheader__image--bg">
			<?php Image::image(
				get_post_thumbnail_id(),
				General::IMAGE_SIZE_FEATURE_4x3_MD,
				General::IMAGE_SIZE_FEATURE_4x3_LRG,
				true,
				'(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w'
			); ?>
			<div class="subheader__image-cover">
				<h3 class="subheader__image-cover-text h1">
					<?php echo $title; ?>
				</h3>
			</div>
		</div>
	<?php } ?>
</div>
