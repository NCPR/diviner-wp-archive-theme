import React, { Component } from 'react';


import { BrowserRouter, Route, Redirect, Switch  } from 'react-router-dom';

// import { BrowserRouter as Router, Route, Link } from "react-router-dom";

import { CONFIG } from './globals/config';
import history from './utils/data/history';

import Main from './containers/main';

/**
 * The main container
 */

class App extends Component {

	render() {
		return (
			<div>
				<BrowserRouter>
					<Switch>
						<Route path={`${CONFIG.base_browse_url}`} component={Main} />
					</Switch>
				</BrowserRouter>
			</div>
		);
	}
}

export default App;
