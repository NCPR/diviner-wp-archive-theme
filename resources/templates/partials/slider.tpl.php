<?php
$slides = !empty($slides) ? $slides : '';
$swiper_data = !empty($swiper_data) ? $swiper_data : '';
?>
<div class="swiper-container" data-js="swiper" data-swiper-data='<?php echo $swiper_data; ?>'>
	<!-- Additional required wrapper -->
	<div class="swiper-wrapper">
		<?echo $slides; ?>
	</div>
	<!-- If we need pagination -->
	<div class="swiper-pagination"></div>

	<!-- If we need navigation buttons -->
	<button class="btn btn--s swiper-button swiper-button-prev">
		<span class="fas fa-arrow-left" aria-hidden="true"></span>
	</button>
	<button class="btn btn--s swiper-button swiper-button-next">
		<span class="fas fa-arrow-right" aria-hidden="true"></span>
	</button>

	<!-- If we need scrollbar -->
	<div class="swiper-scrollbar"></div>
</div>