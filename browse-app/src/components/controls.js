
import React, { Component, PropTypes } from 'react';

class Controls extends Component {

	constructor(props) {
		super(props);
	}

	render() {

		return (
			<div className="a-controls">
				<h2 className="a-header-main">Explore Photos</h2>

				<div className="a-input-group a-input-group--controls">
					<label>Search Archive</label>
					<div className="a-search-row">
						<div
							className="a-search-input"
						>
							<input
								type="text"
								placeholder="Ex: cheese factory, grocery store, mine..."
							/>
						</div>
						<button
							className="btn a-search-button"
						>
							Go
						</button>
					</div>
				</div>
			</div>
		);
	}
}

export default Controls;
