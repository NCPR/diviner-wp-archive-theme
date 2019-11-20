<?php

use \Diviner_Archive\Theme\Diviner_Archive_Image;
use \Diviner_Archive\Config\Diviner_Archive_General;
use \Diviner_Archive\Post_Types\Archive_Item\Diviner_Archive_Archive_Item;

// defaults
$display_excerpt = isset($display_excerpt) ? $display_excerpt : true;
$display_feature = isset($display_feature) ? $display_feature : true;

$image_size_src = Diviner_Archive_General::IMAGE_SIZE_CARD_SM;
$image_size_src_set = Diviner_Archive_General::IMAGE_SIZE_CARD_LRG;

if ( get_post_type() === Diviner_Archive_Archive_Item::NAME ) {
	$image_size_src = Diviner_Archive_General::IMAGE_SIZE_BROWSE_GRID;
	$image_size_src_set = Diviner_Archive_General::IMAGE_SIZE_BROWSE_GRID;
}

$img_classes = [ 'card__feature-image' ];
if ( !get_post_thumbnail_id() ) {
	$img_classes[] = 'card__feature-image--none';
}
$img_classes_output = implode(' ', $img_classes);

$card_classes = [ 'card' ];
$card_classes[] = sprintf( 'card--type-%s', get_post_type() );
// To Do: Add class per aarchive item type
$card_classes_output = implode(' ', $card_classes);

?>

<article class="<?php echo esc_attr( $card_classes_output ); ?>">

	<div class="card__inner">

		<?php
		if ( $display_feature ) {
		?>
			<a href="<?php the_permalink(); ?>" class="card__feature-image-anchor" title="<?php esc_attr(get_the_title()); ?>">
			<div class="<?php echo esc_attr( $img_classes_output ); ?>">
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
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				get_the_excerpt()
			);
		} ?>
	</div>

</article>
