
import React, { Component } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import _ from "lodash";
import autobind from 'autobind-decorator';

import FieldDate from './fieldDate';
import FieldSelect from './fieldSelect';
import FieldTaxonomy from './fieldTaxonomy';
import FieldCpt from './fieldCpt';

import {
	initiateSearch,
	setQueryString,
	setPage,
	setFieldData,
} from '../actions';

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
	FIELD_POSITION_TOP,
} from '../config/settings';

// to allow us to access this in the react select component context
let _this;

class Controls extends Component {

	constructor(props) {
		super(props);
		_this = this;
	}

	@autobind
	searchUpdated(e) {
		this.props.onChangeSearchQuery(e.currentTarget.value);
	}

	@autobind
	onSearchKeyDown(e) {
		if (e.keyCode === 13) {
			this.props.onSubmitSearch();
		}
	}

	@autobind
	onClick(e) {
		e.preventDefault();
		this.props.onSubmitSearch();
	}

	filterFields(fields) {
		return _.map(fields, function(o) {
			if (o && o.position === FIELD_POSITION_TOP) return o;
		});
	}

	createFields(fields) {
		return fields.map(
			(field, i) => {
				if (i < 3) {
					return this.createFieldUI(field, i);
				}
				return '';
			}
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

	render() {
		const searchString = this.props.searchQuery ? this.props.searchQuery : '';
		const fieldsOnTop = this.filterFields(CONFIG.fields);

		const fieldLength = fieldsOnTop.length > 3 ? 3 : fieldsOnTop.length;
		let classes =  'a-control-row';
		classes += `a-control-row--${fieldLength}`;

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
								onKeyDown={this.onSearchKeyDown}
								onChange={this.searchUpdated}
								placeholder="Ex: cheese factory, grocery store, mine..."
								value={searchString}
							/>
						</div>
						<button
							className="btn a-search-button"
							onClick={this.onClick}
						>
							Go
						</button>
					</div>
				</div>

				{
					(fieldsOnTop.length > 0)
						? <div className={classes}>{this.createFields(fieldsOnTop)}</div>
						: ''
				}



			</div>
		);
	}
}


Controls.propTypes = {
	isFetching: PropTypes.bool,
	lastUpdated: PropTypes.number,
	dispatch: PropTypes.func,
	searchQuery: PropTypes.string,
	currentKey: PropTypes.string,
	onChangeSearchQuery: PropTypes.func,
	onSubmitSearch: PropTypes.func,
};

Controls.defaultProps = {
	dispatch: () => {},
	searchQuery: '',
	onChangeSearchQuery: () => {},
	onSubmitSearch: () => {},
};

const mapStateToProps = (state) => ({
	isFetching: state.isFetching,
	lastUpdated: state.lastUpdated,
	searchQuery: state.queryString,
	currentKey: state.currentCacheKey,
});

const mapDispatchToProps = (dispatch) => ({
	onChangeDate: (value) => {
		dispatch(setDateFilter(value));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	},
	onChangeSearchQuery: (value) => {
		dispatch(setQueryString(value));
	},
	onSubmitSearch: () => {
		dispatch(setPage(1));
		dispatch(initiateSearch());
	}
});

export default connect(
	mapStateToProps,
	mapDispatchToProps,
)(Controls);
