<?php

use \Diviner_Archive\Theme\Diviner_Archive_General;

?>
<header class="header" data-js="header">

	<?php Diviner_Archive_General::the_header_brand(); ?>

	<p class="header__lead">
		<?php echo esc_html( $lead ); ?>
	</p>

	<?php Diviner_Archive_General::the_primary_menu(); ?>

	<button class="header__menu-trigger" data-js="header__menu-trigger">
		<span class="fas fa-bars" aria-hidden="true"></span>
		<div class="a11y-hidden">
			<?php echo esc_html__( 'Toggle Menu', 'diviner-archive'); ?>
		</div>
	</button>

	<?php
		/**
		 * Functions hooked into `theme/header/end` action.
		 *
		 * @hooked Diviner_Archive\Structure\render_documentation_button - 10
		 */
		do_action('theme/header/end')
	?>
</header>
<a id="a11y-skip-link-content" tabindex="-1"></a>
