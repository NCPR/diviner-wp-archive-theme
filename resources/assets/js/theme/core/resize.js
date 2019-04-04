/**
 * @module
 * @exports resize
 * @description Kicks in any third party plugins that operate on a sitewide basis.
 */

import { triggerEvent } from '../../utils/events';

const resize = () => {
	// code for resize events can go here

	triggerEvent({ event: 'diviner/resize', native: false });
};

export default resize;
