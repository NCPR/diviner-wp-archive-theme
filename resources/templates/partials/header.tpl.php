<header class="header" data-js="header">

	<?= $brand ?>

	<p class="header__lead"><?= $lead ?></p>

	<?= $primary_menu ?>

	<button class="header__menu-trigger" data-js="header__menu-trigger">
		<span class="fas fa-bars"></span>
		<div class="a11y-hidden">
			<?= __( 'Toggle Menu', 'ncpr-diviner'); ?>
		</div>
	</button>

	<?php
		/**
		 * Functions hooked into `theme/header/end` action.
		 *
		 * @hooked Tonik\Theme\App\Structure\render_documentation_button - 10
		 */
		do_action('theme/header/end')
	?>
</header>
