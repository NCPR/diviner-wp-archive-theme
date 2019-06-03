<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;
use \Diviner\Post_Types\Archive_Item\Post_Meta;

$thumbnail_id = carbon_get_post_meta( get_the_ID(), Post_Meta::FIELD_PHOTO);

if ( !isset( $thumbnail_id ) ) {
	return;
}

$caption = wp_get_attachment_caption($thumbnail_id);
$has_caption = !empty($caption);

?>
<div class="subheader">
	<div class="subheader__image">
		<?php Image::image(
			$thumbnail_id,
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
