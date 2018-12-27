/**
 * @module
 * @exports resize
 * @description Kicks in any third party plugins that operate on a sitewide basis.
 */

import { trigger } from '../../utils/events';

const resize = () => {
	// code for resize events can go here

	trigger({ event: 'diviner/resize', native: false });
};

export default resize;
