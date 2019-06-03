import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import Select from 'react-select';
import { connect } from 'react-redux';

import {
	FIELD_TYPE_SELECT,
} from '../config/settings';
import { carbonFieldSelectToSelectOptions } from '../utils/wp/carbonFieldSelectToSelectOptions';

import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';

// to allow us to access this in the react select component context
let _this;

class FieldSelect extends Component {

	constructor(props) {
		super(props);
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
		if (!field.select_field_options || field.select_field_options.length === 0 ) {
			return '';
		}
		const values = this.props.fieldData[field.field_id]; // as array id IDs
		let options = carbonFieldSelectToSelectOptions(field.select_field_options);
		const valueItems = this.getSelectItemsFromValues(options, values);
		const clearText = 'Clear';
		const isClearable = true;

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
				className="react-select-container"
				classNamePrefix="react-select"
				></Select>
		)
	}

	render() {
		if (!this.props.field) {
			return '';
		}

		const field = this.createField(this.props.field);
		if (!field) {
			return '';
		}

		const dangerousHtml = {__html:this.props.field.title};
		const dangerousHtmlDescription = {__html:this.props.field.helper};
		return (
			<div className="a-field">
				<label dangerouslySetInnerHTML={dangerousHtml} />
				<div className="a-field-input a-field-input--select">{field}</div>
				<small className="a-input-description" dangerouslySetInnerHTML={dangerousHtmlDescription} />
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