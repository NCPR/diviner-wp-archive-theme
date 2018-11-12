import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import Select from 'react-select';
import { connect } from 'react-redux';

import {
	FIELD_DATE_TYPE,
	FIELD_DATE_START,
	FIELD_DATE_END,
	FIELD_DATE_TYPE_CENTURY,
	FIELD_TYPE_SELECT,
} from '../config/settings';
import { carbonFieldSelectToSelectOptions } from '../utils/wp/carbonFieldSelectToSelectOptions';
import { selectTheme, selectStyles } from '../shared/select-styles';

import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';

/*
{
	"id": 159,
	"title": "Test Select Hair Color",
	"position": "left",
	"helper": "Color of hair",
	"field_id": "select_5bcf191008621",
	"display_in_popup": false,
	"select_field_options": [
	{
		"_type": "_",
		"div_field_select_options_value": "red",
		"div_field_select_options_label": "Red"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "blond",
		"div_field_select_options_label": "Blond"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "black",
		"div_field_select_options_label": "Black"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "brown",
		"div_field_select_options_label": "Brown"
	}
],
	"field_type": "diviner_select_field"
}
*/

// to allow us to access this in the react select component context
let _this;

class FieldSelect extends Component {

	constructor(props) {
		super(props)
		_this = this;
	}

	getSelectItemsFromValues(options, values) {
		const selectedOptions = [];
		_.forEach(values, (value) => {
			_.forEach(options, (option) => {
				if (value === option.value) {
					selectedOptions.push(option);
				}
			});
		});
		return selectedOptions;
	}

	onChangeSelectField(e) {
		const newData = _.cloneDeep(_this.props.fieldData);
		if (e === null) {
			newData[this['data-id']] = [];
		} else {
			// save as array of IDs
			const ids = _.map(e, (item) => item.value);
			newData[this['data-id']] = ids;
		}
		_this.props.onChangeFacets(newData);
	}

	createField(field) {
		// console.log('createField', field);
		if (!field.select_field_options || field.select_field_options.length === 0 ) {
			return '';
		}
		const values = this.props.fieldData[field.field_id]; // as array id IDs
		let options = carbonFieldSelectToSelectOptions(field.select_field_options);
		const valueItems = this.getSelectItemsFromValues(options, values);
		const clearText = 'Clear';
		const isClearable = true;

		console.log()

		return (
			<Select
				name={field.field_id}
				data-type={FIELD_TYPE_SELECT}
				data-id={field.field_id}
				clearValueText={clearText}
				isMulti={true}
				options={options}
				isClearable={isClearable}
				onChange={this.onChangeSelectField}
				value={valueItems}
				//theme={(theme) => {return selectTheme(theme);}}
				styles={selectStyles}
				></Select>
		)
	}

	render() {
		if (!this.props.field) {
			return '';
		}
		return (
			<div className="a-field">
				<label>{ this.props.field.title }</label>
				<div className="a-field-input a-field-input--date">{this.createField(this.props.field)}</div>
				<small className="a-input-description">{ this.props.field.helper }</small>
			</div>
		);
	}
}

FieldSelect.propTypes = {
	field: PropTypes.object,
	fieldData: PropTypes.object,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
FieldSelect.defaultProps = {
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
)(FieldSelect);