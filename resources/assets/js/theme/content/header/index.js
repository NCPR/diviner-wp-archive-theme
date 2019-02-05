/**
 * @module
 * @description JavaScript specific to the site header
 */
import delegate from 'delegate';
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';


import { HEADER_BREAKPOINT } from '../../config';
import { on } from '../../../utils/events';

const el = {
	header: document.querySelectorAll('[data-js="header"]')[0],
	primaryMenuWrap: document.querySelectorAll('[data-js="primary-menu__wrap"]')[0],
};

/**
 * @function closeMenu
 * @description Close menu on click
 */

const closeMenu = () => {
	document.body.classList.remove('menu--opened');
	enableBodyScroll(el.primaryMenuWrap);
};

const openMenu = (e) => {
	document.body.classList.add('menu--opened');
	disableBodyScroll(el.primaryMenuWrap);
};


/**
 * @function toggleMenu
 * @description Toggle menu on click
 */

const toggleMenu = (e) => {
	e.preventDefault();
	const shouldActivateMenu = !document.body.classList.contains('menu--opened');
	if (shouldActivateMenu) {
		openMenu();
	} else {
		closeMenu();
	}
};

/**
 * @function closeMenuHandler
 * @description Close menu on click
 */

const closeMenuHandler = (e) => {
	e.preventDefault();
	closeMenu();
};

const getWidth = () => {
	const g = document.getElementsByTagName('body')[0];
	return window.innerWidth || document.documentElement.clientWidth || g.clientWidth;
}

const executeResize = (e) => {
	const width = getWidth();
	if (width > HEADER_BREAKPOINT) {
		closeMenu();
	}
};

/**
 * @function bindEvents
 * @description Bind the events for this module.
 */

const bindEvents = () => {
	on(document, 'diviner/resize', executeResize);  // eslint-disable-line
	/*
	delegate(el.header, '[data-js="trigger-child-menu"]', 'click', toggleSubMenu);
	document.body.addEventListener('keydown', closeOnEsc);
	document.addEventListener('click', maybeClose);
	*/
	delegate(el.header, '[data-js="header__menu-trigger"]', 'click', toggleMenu);
	delegate(el.header, '[data-js="primary-menu__close"]', 'click', closeMenuHandler);
};

/**
 * @function init
 * @description Kick off this modules functions
 */

const header = () => {
	if (el.header) {
		bindEvents();

		console.info('Diviner: Initialized header scripts.');
	}
};

export default header;
