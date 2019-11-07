<?php

use \Diviner_Archive\Theme\Diviner_Archive_Image;
use \Diviner_Archive\Config\Diviner_Archive_General;

$thumbnail_id = get_post_thumbnail_id();

if ( !isset( $thumbnail_id ) ) {
	return;
}

$caption = wp_get_attachment_caption(get_post_thumbnail_id());
$has_caption = !empty($caption);

?>
<div class="subheader">
	<div class="subheader__image">
		<?php Diviner_Archive_Image::image(
			get_post_thumbnail_id(),
			Diviner_Archive_General::IMAGE_SIZE_FEATURE_4x3_MD,
			Diviner_Archive_General::IMAGE_SIZE_FEATURE_4x3_LRG,
			true,
			[ 'display-medium-none' ]
		); ?>
		<?php Diviner_Archive_Image::image(
			get_post_thumbnail_id(),
			Diviner_Archive_General::IMAGE_SIZE_FEATURE_SM,
			Diviner_Archive_General::IMAGE_SIZE_FEATURE_LRG,
			true,
			[ 'display-none', 'display-medium-block' ]
		); ?>
	</div>
	<?php if ( $has_caption ) { ?>
		<div class="subheader__image-caption wrapper">
			<?php echo esc_html( $caption ); ?>
		</div>
	<?php } ?>
</div>
