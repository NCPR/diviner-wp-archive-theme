<?php
$slides = !empty($slides) ? $slides : '';
$swiper_data = !empty($swiper_data) ? $swiper_data : '';
?>
<div class="swiper-container" data-js="swiper" data-swiper-data='<?=$swiper_data ?>'>
	<!-- Additional required wrapper -->
	<div class="swiper-wrapper">
		<?=$slides ?>
	</div>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>

	<!-- If we need navigation buttons -->
	<button class="btn swiper-button swiper-button-prev">
		<span class="fas fa-arrow-left"></span>
	</button>
	<button class="btn swiper-button swiper-button-next">
		<span class="fas fa-arrow-right"></span>
	</button>

	<!-- If we need scrollbar -->
	<div class="swiper-scrollbar"></div>
</div>