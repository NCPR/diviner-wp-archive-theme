/**
 * @module
 * @description Block tweaks
 */

import React from 'react';

import { THEME_BLOCK_IDENTIFIER } from '../config';

const { createHigherOrderComponent } = wp.compose; // eslint-disable-line no-undef

/**
 * @function withCustomClassName
 * @description Add classname
 */

const withCustomClassName = createHigherOrderComponent( ( BlockListBlock ) => {
	return ( props ) => {
		if(props.attributes.size) {
			return(<BlockListBlock { ...props } className={ "block-" + props.attributes.size } />);
		} else {
			return(<BlockListBlock {...props} />);
		}

	};
}, 'withClientIdClassName' );


/**
 * @function init
 * @description Kick off this modules functions
 */

const blocks = () => {
	console.log('blocks');
	const filterName = `${THEME_BLOCK_IDENTIFIER}/add-class-names`;
	wp.hooks.addFilter( 'editor.BlockListBlock', filterName, withCustomClassName ); // eslint-disable-line no-undef

};

export default blocks;
