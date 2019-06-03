/**
 * @module
 * @exports ready
 * @description The core dispatcher for the dom ready event javascript.
 */


import { appReady } from '../../utils/events';

import titleValidation from '../modules/title-validation';

/**
 * @function init
 * @description The core dispatcher for init across the codebase.
 */

const init = () => {

	// initialize the main scripts
	titleValidation();
	
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

