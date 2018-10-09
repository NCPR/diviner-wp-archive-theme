import React, { Component, PropTypes } from 'react';
import _ from 'lodash';
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

	createFields(fields) {
		return fields.map(
			(field, i) => this.createFieldUI(field, i)
		);
	}

	createFieldUI(field, i) {
		console.log(field);
		if (!field) {
			return '';
		}
		return (
			<div key={i}>
			<label>{ field.title }</label>
			</div>
		);
	}

	render() {

		const fieldsOnLeft = _.map(CONFIG.fields, function(o) {
			if (o && o.position === 'left') return o;
		});

		console.log('fieldsOnLeft', fieldsOnLeft);

		return (
			<div className="a-facets">

				<button
					className="btn btn-fullmobile a-toggle-search-btn" >
						Display More Filters
				</button>

				<div className='' aria-hidden='false'>

					<h5>Narrow Results By:</h5>


					{
						(fieldsOnLeft.length > 0)
							? <div className="a-input-group">{this.createFields(fieldsOnLeft)}</div>
							: <div>No fields available</div>
					}


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
