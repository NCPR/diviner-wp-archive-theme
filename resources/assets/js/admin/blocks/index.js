/**
 * @module
 * @description Block tweaks
 */

import React from 'react';

import { THEME_BLOCK_IDENTIFIER } from '../config';

/**
 * @function init
 * @description Kick off this modules functions
 */

const blocks = () => {
	console.log('blocks');
	if (!wp.compose) { // eslint-disable-line no-undef
		return;
	}

	const { createHigherOrderComponent } = wp.compose; // eslint-disable-line no-undef
	const withCustomClassName = createHigherOrderComponent( ( BlockListBlock ) => {
		return ( props ) => {
			if(props.attributes.size) {
				return(<BlockListBlock { ...props } className={ "block-" + props.attributes.size } />);
			} else {
				return(<BlockListBlock {...props} />);
			}

		};
	}, 'withClientIdClassName' );
	const filterName = `${THEME_BLOCK_IDENTIFIER}/add-class-names`;
	wp.hooks.addFilter( 'editor.BlockListBlock', filterName, withCustomClassName ); // eslint-disable-line no-undef

};

export default blocks;
