import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';

import Field from './field';

// CONFIG
import { CONFIG } from '../globals/config';
import {
	FIELD_POSITION_LEFT,
} from '../config/settings';


import {
	initiateSearch,
	setPage,
	clearFacets,
	setFieldData,
	toggleClick,
} from '../actions';

// to allow us to access this in the react select component context
let _this;

class SearchFacets extends Component {

	constructor(props) {
		super(props)
		_this = this;
	}

	@autobind
	onClearClick(e) {
		e.preventDefault();
		this.props.clearFacets();
	}

	@autobind
	onToggleClick() {
		this.props.onToggleClick();
	}

	createFields(fields) {
		return fields.map(
			(field, i) => {
				return (
					<Field field={field} key={i} />
				);
			}
		);
	}

	filterFields(fields) {
		return _.filter(fields, function(o) {
			return (o && o.position === FIELD_POSITION_LEFT);
		});
	}

	render() {
		const ariaHidden = !this.props.filterOpen;
		let toggleText = 'Display More Filters';
		const facetsWrapClasses = [
			'a-facets__wrap'
		];
		if (this.props.filterOpen) {
			facetsWrapClasses.push('a-facets__wrap--open');
			toggleText = 'Close More Filters';
		}

		const fieldsOnLeft = this.filterFields(CONFIG.fields);

		return (
			<div className="a-facets">

				<button
					className="btn btn-fullmobile a-toggle-search-btn"
					onClick={this.onToggleClick}
					>
					{toggleText}
				</button>

				<div className={facetsWrapClasses.join(' ')} aria-hidden={ariaHidden}>
					<h5>Narrow Results By:</h5>
					{
						(fieldsOnLeft.length > 0)
							? <div className="a-input-group">{this.createFields(fieldsOnLeft)}</div>
							: <div>No fields available</div>
					}

					<div className="a-input-group">
						<button
							className="btn btn-s btn-fullmobile a-clear-button"
							onClick={this.onClearClick}
						>
							Reset Search Filters
						</button>
					</div>

				</div>

			</div>
		);
	}
}


SearchFacets.propTypes = {
	fields: PropTypes.array,
	fieldData: PropTypes.object,
	order_by: PropTypes.string,
	filterOpen: PropTypes.bool,
	onToggleClick: PropTypes.func,
	clearFacets: PropTypes.func,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
SearchFacets.defaultProps = {
	fields: [],
	fieldData: {},
	order_by: null,
	filterOpen: false,
	onToggleClick: () => {},
	clearFacets: () => {},
	onChangeFacets: () => {},
};

const mapStateToProps = (state) => ({
	filterOpen: state.filterOpen,
	fieldData: state.fieldData,
});

/**
 * mapDispatchToProps
 *
 * Mapping property to dispatches
 */
const mapDispatchToProps = (dispatch) => ({
	onToggleClick: () => {
		dispatch(toggleClick());
	},
	onChangeFacets: (value) => {
		dispatch(setFieldData(value));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	},
	clearFacets: () => {
		dispatch(clearFacets());
	},
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(SearchFacets);