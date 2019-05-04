<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;

$thumbnail_id = get_post_thumbnail_id();

if ( !isset( $thumbnail_id ) ) {
	return;
}

$caption = wp_get_attachment_caption(get_post_thumbnail_id());
$has_caption = !empty($caption);

?>
<div class="subheader">
	<div class="subheader__image">
		<?php Image::image(
			get_post_thumbnail_id(),
			General::IMAGE_SIZE_ARCHIVE_SINGLE_M,
			General::IMAGE_SIZE_ARCHIVE_SINGLE_LRG,
			true
		); ?>
	</div>
	<?php if ( $has_caption ) { ?>
		<div class="subheader__image-caption">
			<?php echo $caption; ?>
		</div>
	<?php } ?>
</div>
