/**
 * @module
 * @description JavaScript specific to the site header
 */
import delegate from 'delegate';
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';


import { HEADER_BREAKPOINT } from '../../config';
import { on } from '../../../utils/events';
import * as tools from '../../../utils/tools';

const el = {
	header: tools.getNodes('header')[0],
	primaryMenuWrap: tools.getNodes('primary-menu__wrap')[0],
};

/**
 * @function closeMenu
 * @description Close menu on click
 */

const closeMenu = () => {
	tools.removeClass(document.body, 'menu--opened');
	enableBodyScroll(el.primaryMenuWrap);
};

const openMenu = (e) => {
	tools.addClass(document.body, 'menu--opened');
	disableBodyScroll(el.primaryMenuWrap);
};


/**
 * @function toggleMenu
 * @description Toggle menu on click
 */

const toggleMenu = (e) => {
	console.log('toggleMenu');
	e.preventDefault();
	const shouldActivateMenu = !tools.hasClass(document.body, 'menu--opened');
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
	console.log('closeMenuHandler');
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
