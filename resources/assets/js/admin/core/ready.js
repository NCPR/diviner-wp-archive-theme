/**
 * @module
 * @exports ready
 * @description The core dispatcher for the dom ready event javascript.
 */

import _ from 'lodash';

import { on, ready } from '../../utils/events';

/**
 * @function bindEvents
 * @description Bind global event listeners here,
 */

const bindEvents = () => {
	// on(window, 'resize', _.debounce(resize, 200, false));
};

/**
 * @function init
 * @description The core dispatcher for init across the codebase.
 */

const init = () => {
	// apply browser classes

	bindEvents();

	// initialize the main scripts

	console.info('Square One BE: Initialized all javascript that targeted document ready.');
};

/**
 * @function domReady
 * @description Export our dom ready enabled init.
 */

const domReady = () => {
	ready(init);
};

export default domReady;

