import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';
import ASlider from './aslider';

import {
	FIELD_DATE_TYPE,
	FIELD_DATE_START,
	FIELD_DATE_END,
	FIELD_DATE_TYPE_CENTURY
} from '../config/settings';


import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';

// to allow us to access this in the react select component context
let _this;

class FieldDate extends Component {

	constructor(props) {
		super(props)
		_this = this;
	}

	@autobind
	onChangeDateField(e) {
		console.log('onChangeDateField', e);
		const newData = _.cloneDeep(_this.props.fieldData);
		newData[e.id] = e.value;
		this.props.onChangeFacets(newData);
	}

	createDateField(field) {
		let step = 1;
		if (field[FIELD_DATE_TYPE] === FIELD_DATE_TYPE_CENTURY) {
			step = 10;
		}
		let min = 1800;
		let max = 2018;
		if (field[FIELD_DATE_START]) {
			// const start = field[FIELD_DATE_START].substring(0, 4);
			const startDate = new Date(field[FIELD_DATE_START].substring(0, 4));
			min = startDate.getFullYear();
		}
		if (field[FIELD_DATE_END]) {
			// const end = field[FIELD_DATE_END].substring(0, 4);
			const endDate = new Date(field[FIELD_DATE_END].substring(0, 4));
			max = endDate.getFullYear();
		}

		let value = this.props.fieldData[field.field_id];
		if (!value.length) {
			value = [min, max];
		}

		return (
			<ASlider
				id={field.field_id}
				min={min}
				max={max}
				step={step}
				value={value}
				onAfterChange={this.onChangeDateField}
			>
			</ASlider>
		);
	}

	render() {
		if (!this.props.field) {
			return '';
		}
		return (
			<div className="a-field">
				<label>{ this.props.field.title }</label>
				<div className="a-field-input a-field-input--date">{this.createDateField(this.props.field)}</div>
				<small className="a-input-description">{ this.props.field.helper }</small>
			</div>
		);
	}
}

FieldDate.propTypes = {
	field: PropTypes.object,
	fieldData: PropTypes.object,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
FieldDate.defaultProps = {
	field: {},
	fieldData: {},
	onChangeFacets: () => {},
};

const mapStateToProps = (state) => ({
	fieldData: state.fieldData,
});

/**
 * mapDispatchToProps
 *
 * Mapping property to dispatches
 */
const mapDispatchToProps = (dispatch) => ({
	onChangeFacets: (value) => {
		dispatch(setFieldData(value));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	},
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(FieldDate);