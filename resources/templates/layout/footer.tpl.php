<?php

use \Diviner_Archive\Theme\Diviner_Archive_General;
use \Diviner_Archive\Theme\Diviner_Archive_Widgets;

// defaults
$show_menu = has_nav_menu( 'footer' );
$has_widget_area_1 = is_active_sidebar( Diviner_Archive_Widgets::SIDEBAR_ID_FOOTER_1 );
$has_widget_area_2 = is_active_sidebar( Diviner_Archive_Widgets::SIDEBAR_ID_FOOTER_2 );

$show_col2 = $has_widget_area_2;
$show_col1 = $show_menu || $has_widget_area_1;
$show_row1 = $show_col1 || $has_widget_area_2;

$row_col1_classes = [
	'gr-12'
];
$row_col2_classes = [
	'gr-12'
];

if ( $show_col1 && $show_col2 ) {
	$row_col1_classes[] = 'gr-8@medium';
	$row_col2_classes[] = 'gr-4@medium';
}

$row_col1_classes_output = join( ' ', $row_col1_classes);
$row_col2_classes_output = join( ' ', $row_col2_classes);

?>

			<footer class="footer">

				<div class="wrapper">

					<?php if ( $show_row1 ) { ?>

						<div class="row">

							<?php if ( $show_col1 ) { ?>

								<div class="<?php echo esc_attr( $row_col1_classes_output ); ?>">

									<?php Diviner_Archive_General::output_footer_menu(); ?>
									<?php Diviner_Archive_Widgets::render_sidebar(Diviner_Archive_Widgets::SIDEBAR_ID_FOOTER_1) ?>

								</div>

							<?php } ?>

							<?php if ( $show_col2 ) { ?>

								<div class="<?php echo esc_attr($row_col2_classes_output); ?>">

									<?php Diviner_Archive_Widgets::render_sidebar(Diviner_Archive_Widgets::SIDEBAR_ID_FOOTER_2); ?>

								</div>

							<?php } ?>

						</div>

					<?php } ?>

				</div>

			</footer>

		</main>
		<?php wp_footer(); ?>
	</body>
</html>
