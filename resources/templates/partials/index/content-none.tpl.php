<?php
use Diviner\Admin\Customizer;
use Diviner\Theme\General;
?>

<div class="single-item__nocontent">

	<h1 class="h1 <?php echo Customizer::CUSTOMIZER_FONT_CLASSNAME_HEADER; ?>">
		<?php echo General::get_page_title(); ?>
	</h1>

	<div>
		<?php get_search_form(); ?>
	</div>

</div>
