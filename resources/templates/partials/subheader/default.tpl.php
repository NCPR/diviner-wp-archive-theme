<?php

use \Diviner\Theme\Image;
use Diviner\Config\General;

?>
<div class="subheader">
	<div class="subheader__image">
		<?php Image::image( get_post_thumbnail_id(), General::IMAGE_SIZE_FEATURE_SM, General::IMAGE_SIZE_FEATURE_LRG ); ?>
	</div>
</div>