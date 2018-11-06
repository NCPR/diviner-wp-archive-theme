import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';

import FieldDate from './fieldDate';
import FieldSelect from './fieldSelect';
import FieldTaxonomy from './fieldTaxonomy';
import FieldCpt from './fieldCpt';

// CONFIG
import { CONFIG } from '../globals/config';
import { FIELD_TYPE_TAXONOMY,
			FIELD_TYPE_CPT,
			FIELD_TYPE_TEXT,
			FIELD_TYPE_SELECT,
			FIELD_TYPE_DATE,
			FIELD_DATE_TYPE,
			FIELD_DATE_START,
			FIELD_DATE_END,
			FIELD_DATE_TYPE_CENTURY,
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
			(field, i) => this.createFieldUI(field, i)
		);
	}

	createFieldUI(field, i) {
		if (!field) {
			return '';
		}
		return (
			<div className="a-input-group" key={i}>
				{
					(field.field_type === FIELD_TYPE_TAXONOMY )
						? <div className="a-field-input a-field-input--taxonomy"><FieldTaxonomy field={field} /></div>
						: ''
				}
				{
					(field.field_type === FIELD_TYPE_CPT )
						? <div className="a-field-input a-field-input--cpt"><FieldCpt field={field} /></div>
						: ''
				}
				{
					(field.field_type === FIELD_TYPE_DATE )
						? <div className="a-field-input a-field-input--date"><FieldDate field={field} /></div>
						: ''
				}
				{
					(field.field_type === FIELD_TYPE_SELECT )
						? <div className="a-field-input a-field-input--select"><FieldSelect field={field} /></div>
						: ''
				}
			</div>
		);
	}

	filterFields(fields) {
		return _.map(fields, function(o) {
			if (o && o.position === FIELD_POSITION_LEFT) return o;
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