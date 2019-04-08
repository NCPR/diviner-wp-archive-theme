<?php

use \Diviner\Theme\Image;
use \Diviner\Config\General;

$thumbnail_id = get_post_thumbnail_id();

if ( !isset( $thumbnail_id ) ) {
	return;
}

?>
<div class="subheader">
	<div class="subheader__image">
		<?php Image::image(
			get_post_thumbnail_id(),
			General::IMAGE_SIZE_ARCHIVE_SINGLE_M,
			General::IMAGE_SIZE_ARCHIVE_SINGLE_LRG,
			true,
			'(max-width: 768px) 800w, (max-width: 1024px) 1200w, (min-width: 1025px) 2000w'
		); ?>
	</div>
</div>
