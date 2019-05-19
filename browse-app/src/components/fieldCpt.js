import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import Select from 'react-select';
import { connect } from 'react-redux';

import {
	FIELD_TYPE_CPT,
} from '../config/settings';

import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';
import { CONFIG } from "../globals/config";
import { postsToSelectOptions } from "../utils/wp/postsToSelectOptions"

// to allow us to access this in the react select component context
let _this;

class FieldCpt extends Component {

	constructor(props) {
		super(props)
		_this = this;
	}

	onChangeField(e) {
		const newData = _.cloneDeep(_this.props.fieldData);
		if (e === null) {
			newData[this['data-id']] = '';
		} else {
			newData[this['data-id']] = e.value;
		}
		_this.props.onChangeFacets(newData);
	}

	getCptSelectItemFromId(cptId, id) {
		return _.find(CONFIG.cpt_posts[cptId], { 'value': id })
	}

	createField(field) {
		if (!CONFIG.cpt_posts[field.cpt_field_id]) {
			return;
		}
		const options = postsToSelectOptions(CONFIG.cpt_posts[field.cpt_field_id]);
		const value = this.props.fieldData[field.field_id]; // as a single ID
		const valueItem = this.getCptSelectItemFromId(field.cpt_field_id, value);
		const clearText = 'Clear '+field.taxonomy_field_singular_label;
		const isClearable = true;
		return (
			<Select
				name={field.cpt_field_id}
				clearValueText={clearText}
				data-type={FIELD_TYPE_CPT}
				data-id={field.field_id}
				options={options}
				isClearable={isClearable}
				onChange={this.onChangeField}
				value={valueItem}
				className="react-select-container"
				classNamePrefix="react-select"
			></Select>
		);
	}

	render() {
		if (!this.props.field) {
			return '';
		}
		const fieldOutput = this.createField(this.props.field);
		if (!fieldOutput) {
			return '';
		} else {
			const dangerousHtml = {__html:this.props.field.title};
			const dangerousHtmlDescription = {__html:this.props.field.helper};
			return (
				<div className="a-field">
					<label dangerouslySetInnerHTML={dangerousHtml} />
					<div className="a-field-input a-field-input--date">{fieldOutput}</div>
					<small className="a-input-description" dangerouslySetInnerHTML={dangerousHtmlDescription} />
				</div>
			);
		}
	}
}

FieldCpt.propTypes = {
	field: PropTypes.object,
	fieldData: PropTypes.object,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
FieldCpt.defaultProps = {
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
)(FieldCpt);