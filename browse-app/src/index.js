import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { AppContainer } from 'react-hot-loader';

import App from './app';
import configureStore from './config/configureStore';

const archiverContainer = document.getElementById('browse-app');
const store = configureStore();

if (archiverContainer) {
	ReactDOM.render(
		<Provider store={store}>
			<AppContainer>
				<App></App>
			</AppContainer>
		</Provider>,
		archiverContainer
	);
}

