			<footer class="footer">

				<div class="wrapper wrapper--full">

					<div class="row">

						<div class="gr-12 gr-6@medium">
							<?= $footer_menu ?>
						</div>

						<div class="gr-12 gr-6@medium">
							<?= $footer_social ?>
						</div>

					</div>

					<?php if ( !empty( $footer_copy ) ) { ?>

						<div class="row">
							<div class="gr-12">
								<div class="footer__copy d-content d-content--inverse">
									<?= $footer_copy ?>
								</div>
							</div>
						</div>

					<?php } ?>

				</div>

			</footer>
		</main>
		<?php wp_footer(); ?>
	</body>
</html>
