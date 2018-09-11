import React, { Component } from 'react';

import {
	BrowserRouter,
	Route
} from 'react-router-dom';

import { CONFIG } from './globals/config';
import history from './utils/data/history';

import Main from './containers/main';

/**
 * The main container
 */

console.log('CONFIG', CONFIG);

class App extends Component {

	render() {
		return (
			<div>
				<BrowserRouter history={history}>
					<Route path={`${CONFIG.base_browse_url}`} component={Main} />
				</BrowserRouter>
			</div>
		);
	}
}

export default App;
