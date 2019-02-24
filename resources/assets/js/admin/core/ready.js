/**
 * @module
 * @exports ready
 * @description The core dispatcher for the dom ready event javascript.
 */

import { appReady } from '../../utils/events';

import blocks from '../blocks';
import test from '../test';

/**
 * @function bindEvents
 * @description Bind global event listeners here,
 */

const bindEvents = () => {

};

/**
 * @function init
 * @description The core dispatcher for init across the codebase.
 */

const init = () => {
	// apply browser classes

	bindEvents();

	// initialize the main scripts

	blocks();
	test();

	console.info('Diviner: Initialized all javascript that targeted document ready.');
};

/**
 * @function domReady
 * @description Export our dom ready enabled init.
 */

const domReady = () => {
	appReady(init);
};

export default domReady;

