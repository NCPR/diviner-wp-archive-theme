import React, { Component } from 'react';

import { BrowserRouter, Route, Redirect, Switch  } from 'react-router-dom';
import { CONFIG } from './globals/config';
import { isPlainPermalinkStructure } from './utils/data/permalinks';
import Main from './containers/main';

/**
 * The main container
 */

class App extends Component {

	render() {

		const path = isPlainPermalinkStructure() ? '' : CONFIG.base_browse_url;

		return (
			<div>
				<BrowserRouter>
					<Switch>
						<Route path={`${path}`} component={Main} />
					</Switch>
				</BrowserRouter>
			</div>
		);
	}
}

export default App;
