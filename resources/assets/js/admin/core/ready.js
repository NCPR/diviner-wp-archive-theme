/**
 * @module
 * @exports ready
 * @description The core dispatcher for the dom ready event javascript.
 */


import { appReady } from '../../utils/events';

/**
 * @function bindEvents
 * @description Bind global event listeners here,
 */

const bindEvents = () => {
	/*
	const addBlockClassName = ( props, blockType ) => {
		console.log('addBlockClassName', props, blockType );
		if(blockType.name === 'core/list') {
			return Object.assign( props, { class: 'wp-block-TEST' } );
		}
		return props;
	};

	wp.hooks.addFilter(
		'blocks.getSaveContent.extraProps',
		'gdt-guten-plugin/add-block-class-name',
		addBlockClassName
	);
	*/
};

/**
 * @function init
 * @description The core dispatcher for init across the codebase.
 */

const init = () => {
	// apply browser classes

	bindEvents();

	// initialize the main scripts

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

