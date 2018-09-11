import React, { Component } from 'react';
import { connect } from 'react-redux';

import styles from './main.pcss';

/**
 * The main container
 */

class Main extends Component {

	render() {
		return (
			<div className={styles.main}>
				Browse Application
			</div>
		);
	}
}

export default Main;
// export default connect(null, { startApp })(Main);
