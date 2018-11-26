import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { AppContainer } from 'react-hot-loader';

import App from './app';
import configureStore from './config/configureStore';

/* global PRODUCTION b:true */
// console.log('Running App in PRODUCTION ', PRODUCTION);

const archiverContainer = document.getElementById('browse-app');
const store = configureStore();

ReactDOM.render(
	<Provider store={store}>
		<AppContainer>
			<App></App>
		</AppContainer>
	</Provider>,
	archiverContainer
);



/* global PRODUCTION b:true */

// console.log('Running App in PRODUCTION ', PRODUCTION);



/*
ReactDOM.render(
	<AppContainer>
		<App></App>
	</AppContainer>,
	archiverContainer
);
*/


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

