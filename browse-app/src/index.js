import React from 'react';
import ReactDOM from 'react-dom';
import { AppContainer } from 'react-hot-loader';

import App from './app';

const archiverContainer = document.getElementById('browse-app');

/* global PRODUCTION b:true */

// console.log('Running App in PRODUCTION ', PRODUCTION);

ReactDOM.render(
	<AppContainer>
		<App></App>
	</AppContainer>,
	archiverContainer
);


/*
import React from 'react';
import ReactDOM from 'react-dom';
import { AppContainer } from 'react-hot-loader';

import App from './app';

const archiverContainer = document.getElementById('browse-app');

console.log('archiverContainer', archiverContainer);
console.log('App', App);

ReactDOM.render(
<App></App>,
archiverContainer
);
*/

