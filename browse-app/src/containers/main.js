import React, { Component } from 'react';
import { connect } from 'react-redux';

import SearchFacets from '../components/searchfacets';
import Controls from '../components/controls';
import Grid from '../components/grid';
import Popup from '../components/popup';

import { startApp } from '../actions';

/**
 * The main container
 */

class Main extends Component {

	componentDidMount() {
		this.props.startApp(this.props.location);
	}

	render() {
		return (
			<div className='a-main'>
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
				<Popup></Popup>
			</div>
		);
	}
}

export default connect(null, { startApp })(Main);
