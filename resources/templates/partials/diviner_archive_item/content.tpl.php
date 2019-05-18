<?php
use Diviner\Theme\General;
use Diviner\Post_Types\Archive_Item\Post_Meta as Archive_Item_Post_Meta;
use Diviner\Post_Types\Archive_Item\Theme as Archive_Item_Theme;
use Diviner\Admin\Settings as GeneralSettings;
use Diviner\Theme\Widgets\Widget_Related_Items;

$type = carbon_get_post_meta( get_the_ID(), Archive_Item_Post_Meta::FIELD_TYPE );
$show_audio = ( $type === Archive_Item_Post_Meta::FIELD_TYPE_AUDIO || $type === Archive_Item_Post_Meta::FIELD_TYPE_MIXED );
$show_video = ( $type === Archive_Item_Post_Meta::FIELD_TYPE_VIDEO || $type === Archive_Item_Post_Meta::FIELD_TYPE_MIXED );
$show_document = ( $type === Archive_Item_Post_Meta::FIELD_TYPE_DOCUMENT || $type === Archive_Item_Post_Meta::FIELD_TYPE_MIXED );
$show_feature_image = ( $type === Archive_Item_Post_Meta::FIELD_TYPE_PHOTO || $type === Archive_Item_Post_Meta::FIELD_TYPE_MIXED );

$show_related = carbon_get_theme_option(GeneralSettings::FIELD_GENERAL_RELATED_FIELD);

?>

<article class="single-item single-item--post">

	<header class="single-item__header">
		<?php
		do_action('theme/header/before-title');
		?>
		<h1 class="single-item__header-title h1 page-title"><?php the_title(); ?></h1>
		<?php
		do_action('theme/header/after-title');
		?>
	</header>

	<?php if ( $show_audio ) {
		// standard audio
		$audio_output = Archive_Item_Theme::render_audio();
		if (!empty($audio_output)) {
			printf(
				'<div class="archive-item__content-block">%s</div>',
				$audio_output
			);
		}
		// oembed audio
		$audio_oembed_output = Archive_Item_Theme::render_oembed_audio();
		if (!empty($audio_oembed_output)) {
			printf(
				'<div class="archive-item__content-block">%s</div>',
				$audio_oembed_output
			);
		}
		?>
	<?php } ?>

	<?php
	if ($show_feature_image) {
		$photo_output = Archive_Item_Theme::render_photo();
		if (!empty($photo_output)) {
			printf(
				'<div class="archive-item__content-block">%s</div>',
				$photo_output
			);
		}
	}
	?>

	<?php
	if ($show_video) {
		$video_oembed_output = Archive_Item_Theme::render_oembed_video();
		if (!empty($video_oembed_output)) {
			printf(
				'<div class="archive-item__content-block">%s</div>',
				$video_oembed_output
			);
		}

	}
	?>


	<?php
	if ($show_document) {
		$document_output = Archive_Item_Theme::render_document_iframe();
		if (!empty($document_output)) {
			printf(
				'<div class="archive-item__content-block">%s</div>',
				$document_output
			);
		}

	}
	?>

	<div class="single-item__layout">

		<?php
		$single_meta = Archive_Item_Theme::render_meta_fields();
		if (!empty($single_meta) || $show_document) {
			?>

			<aside class="sidebar sidebar--grey sidebar--pull-right">

				<div class="sidebar__content">

					<h5 class="sidebar__title h5">Details</h5>

					<?php
					if ( $show_document ) {
						$document_output = Archive_Item_Theme::render_document();
						if ( ! empty( $document_output ) ) {
							printf(
								'<div class="archive-item__content-block archive-item__content-block--document">%s</div>',
								$document_output
							);
						}
					}
					?>

					<?php
					echo $single_meta;
					?>

				</div>

			</aside>

			<?php
		}
		?>

		<div class="d-content">

			<?php
			do_action('theme/before-content');
			?>

			<?php the_content(); ?>
		</div>

	</div>

	<?php
	if ( $show_related ) {
		echo '<div class="archive-item__content-block archive-item__content-block--related">';
		the_widget(
			'\Diviner\Theme\Widgets\Widget_Related_Items',
			[],
			[
				'before_title' => '<h3 class="widgettitle h3">',
				'after_title' => '</h3>',
			]
		);
		echo '</div>';
	}
	?>

	<?php
	do_action('theme/article-end');
	?>

</article>
