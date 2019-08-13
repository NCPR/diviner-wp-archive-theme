<?php

// defaults
$show_menu = !empty( $footer_menu );
$show_col2 = $show_widget_area_2 = !empty( $footer_widget_area_2 );
$show_widget_area_1 = !empty( $footer_widget_area_1 );
$show_col1 = $show_menu || $show_widget_area_1;
$show_row1 = $show_col1 || $show_widget_area_2;

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

								<div class="<?php echo $row_col1_classes_output; ?>">

									<?php echo $footer_menu; ?>
									<?php echo $footer_widget_area_1; ?>

								</div>

							<?php } ?>

							<?php if ( $show_col2 ) { ?>

								<div class="<?php echo $row_col2_classes_output; ?>">

									<?php echo $footer_widget_area_2; ?>

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
