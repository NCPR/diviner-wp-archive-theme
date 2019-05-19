import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import Select from 'react-select';
import { connect } from 'react-redux';

import {
	FIELD_TYPE_TAXONOMY,
} from '../config/settings';

import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';
import { CONFIG } from "../globals/config";
import { termsToSelectOptions } from "../utils/wp/termsToSelectOptions";
import { getTaxonomyItemsFromTermIds } from "../utils/data/fieldUtils";

// to allow us to access this in the react select component context
let _this;

class FieldTaxonomy extends Component {

	constructor(props) {
		super(props)
		_this = this;
	}

	onChangeField(e) {
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
		if (!CONFIG.taxonomies[field.taxonomy_field_name]) {
			return '';
		}
		const options = termsToSelectOptions(CONFIG.taxonomies[field.taxonomy_field_name]);
		const value = this.props.fieldData[field.field_id]; // as array id IDs
		const valueItems = termsToSelectOptions(getTaxonomyItemsFromTermIds(field.taxonomy_field_name, value));
		const clearText = 'Clear';
		const isClearable = true;
		return (
			<Select
				name={field.taxonomy_field_name}
				data-type={FIELD_TYPE_TAXONOMY}
				data-id={field.field_id}
				clearValueText={clearText}
				isMulti={true}
				options={options}
				isClearable={isClearable}
				onChange={this.onChangeField}
				value={valueItems}
				className="react-select-container"
				classNamePrefix="react-select"
			></Select>
		);
	}

	render() {
		if (!this.props.field) {
			return '';
		}
		const dangerousHtml = {__html:this.props.field.title};
		const dangerousHtmlDescription = {__html:this.props.field.helper};
		return (
			<div className="a-field">
				<label dangerouslySetInnerHTML={dangerousHtml} />
				<div className="a-field-input a-field-input--date">{this.createField(this.props.field)}</div>
				<small className="a-input-description" dangerouslySetInnerHTML={dangerousHtmlDescription} />
			</div>
		);
	}
}

FieldTaxonomy.propTypes = {
	field: PropTypes.object,
	fieldData: PropTypes.object,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
FieldTaxonomy.defaultProps = {
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
)(FieldTaxonomy);