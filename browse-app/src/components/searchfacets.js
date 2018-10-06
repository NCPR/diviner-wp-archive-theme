import React, { Component, PropTypes } from 'react';

import Select from 'react-select';

// CONFIG
import { CONFIG } from '../globals/config';

import { connect } from 'react-redux';



class SearchFacets extends Component {

	constructor(props) {
		super(props);
	}

	onClearClick() {
		// this.props.clearFacets();
	}

	onToggleClick() {
		// this.props.onToggleClick();
	}


	render() {

		return (
			<div className="a-facets">

				<button
					className="btn btn-fullmobile a-toggle-search-btn" >
						Display More Filters
				</button>

				<div className='' aria-hidden='false'>

					<h5>Narrow Results By:</h5>

					<div className="a-input-group">
						<label>Town</label>
						<Select
							name="location"
							clearValueText="Clear Town"
						></Select>
								<small className="a-input-description">Ex: airplanes, horses, downtowns</small>
					</div>

					<div className="a-input-group">
						<button
							className="btn btn-s btn-fullmobile a-clear-button"
						>
							Reset Search Filters
						</button>
					</div>

				</div>

			</div>
		);
	}
}

export default SearchFacets;
