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

$img_classes = [ 'card__feature-image' ];
if ( !get_post_thumbnail_id() ) {
	$img_classes[] = 'card__feature-image--none';
}
$img_classes_output = implode(' ', $img_classes);

$card_classes = [ 'card' ];
$card_classes[] = sprintf( 'card--type-%s', get_post_type() );
if ( get_post_type() === Archive_Item::NAME ) {
	$archive_item_type = carbon_get_post_meta( get_the_ID(), \Diviner\Post_Types\Archive_Item\Post_Meta::FIELD_TYPE );
	$card_classes[] = sprintf( 'card--ai-type-%s', $archive_item_type );
}
$card_classes_output = implode(' ', $card_classes);

?>

<article class="<?php echo $card_classes_output; ?>">

	<div class="card__inner">

		<?php
		if ( $display_feature ) {
		?>
			<a href="<?php the_permalink(); ?>" class="card__feature-image-anchor" title="<?php esc_attr_e(get_the_title()); ?>">
			<div class="<?php echo $img_classes_output; ?>">
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
