import React, { Component } from 'react';
import { connect } from 'react-redux';

/**
 * The main container
 */

class Main extends Component {

	render() {
		return (
			<div className="a-main">
				Browse Application
			</div>
		);
	}
}

// export default Main;
export default connect(null, { startApp })(Main);
