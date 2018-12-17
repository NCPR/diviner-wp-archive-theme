/**
 * @module
 * @description JavaScript specific to the site header
 */
import delegate from 'delegate';

import { HEADER_BREAKPOINT } from '../../config';
import { on } from '../../../utils/events';
import * as tools from '../../../utils/tools';

const el = {
	header: tools.getNodes('header')[0],
};


/**
 * @function toggleMenu
 * @description Toggle menu on click
 */

const toggleMenu = (e) => {
	console.log('toggleMenu');
	e.preventDefault();
	const clickedItem = e.delegateTarget;
	const shouldActivateMenu = !tools.hasClass(document.body, 'menu--opened');

	if (shouldActivateMenu) {
		tools.addClass(document.body, 'menu--opened');
	} else {
		tools.removeClass(document.body, 'menu--opened');
	}
};

/**
 * @function bindEvents
 * @description Bind the events for this module.
 */

const bindEvents = () => {
	//on(document, 'modern_tribe/resize_executed', (e) => executeResize(e));  // eslint-disable-line
	//on(document, 'modern_tribe/scroll', handleScroll);
	/*
	delegate(el.header, '[data-js="trigger-child-menu"]', 'click', toggleSubMenu);
	document.body.addEventListener('keydown', closeOnEsc);
	document.addEventListener('click', maybeClose);
	*/
	delegate(el.header, '[data-js="header__menu-trigger"]', 'click', toggleMenu);
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
