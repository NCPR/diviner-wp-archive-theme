/**
 * @module
 * @description JavaScript for swiper
 */

import Swiper from 'swiper';
import _ from 'lodash';

const el = {
	swipers: document.querySelectorAll('[data-js="swiper"]'),
};


/**
 * @function getDefaultOptions
 * @description get options
 */

const getDefaultOptions = () => {
	return {
		// accessibility
		a11y: {
			prevSlideMessage: 'Previous slide',
			nextSlideMessage: 'Next slide',
		},
		// Navigation arrows
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		autoHeight: false,
		// Default parameters for smallest screen
		slidesPerView: 1,
		spaceBetween: 10,
		// Responsive breakpoints
		breakpointsInverse: true,
		breakpoints: {
			// when window width is <= 320px
			320: {
				slidesPerView: 1,
				spaceBetween: 10
			},
			// when window width is <= 480px
			480: {
				slidesPerView: 2,
				spaceBetween: 20
			},
			// when window width is <= 640px
			640: {
				slidesPerView: 3,
				spaceBetween: 30
			}
		}
	}
};

const buildSwipers = () => {
	const options = getDefaultOptions();

	// ToDo handle possible customization for each slider
	el.swipers.forEach((swiper) => {
		const id = _.uniq('swiper-');
		swiper.setAttribute('data-swiper-id', id);
		const swiperOptions = swiper.getAttribute('data-swiper-data');
		const mergedOptions = Object.assign(options, JSON.parse(swiperOptions));
		const mySwiper = new Swiper(
			`[data-swiper-id="${id}"]`,
			mergedOptions
		);
	});
};


/**
 * @function init
 * @description Kick off this modules functions
 */

const init = () => {
	if (el.swipers.length) {
		buildSwipers();
	}


	console.info('Diviner: Initialized swiper scripts.');
};

export default init;
