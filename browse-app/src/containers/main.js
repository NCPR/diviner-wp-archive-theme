import React, { Component } from 'react';
import { connect } from 'react-redux';
import styles from './main.pcss';
import gridStyles from '../styles/grid.pcss';

import SearchFacets from '../components/searchfacets';
import Controls from '../components/controls';
import Grid from '../components/grid';

/**
 * The main container
 */

class Main extends Component {

	render() {
		return (
			<div className={styles.main}>
				<div className="row">
					<div className="gr-12">
						<Controls />
					</div>
				</div>
				<div className="row">
					<div className="gr-12 gr-3@medium">
						<SearchFacets />
					</div>
					<div className="gr-12 gr-9@medium">
						<Grid />
					</div>
				</div>
			</div>
		);
	}
}

export default Main;
// export default connect(null, { startApp })(Main);
