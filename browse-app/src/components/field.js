import React, { Component } from 'react';
import PropTypes from 'prop-types';

import {
	FIELD_TYPE_TAXONOMY,
	FIELD_TYPE_CPT,
	FIELD_TYPE_SELECT,
	FIELD_TYPE_DATE,
	FIELD_TYPE_TEXT,
} from '../config/settings';

import FieldTaxonomy from "./fieldTaxonomy";
import FieldCpt from "./fieldCpt";
import FieldDate from "./fieldDate";
import FieldSelect from "./fieldSelect";
import FieldText from "./fieldText";

class Field extends Component {

	render() {
		if (!this.props.field) {
			return '';
		}
		return (
			<div className="a-input-group">
				{
					(this.props.field.field_type === FIELD_TYPE_TAXONOMY )
						? <div className="a-field-input a-field-input--taxonomy"><FieldTaxonomy field={this.props.field} /></div>
						: ''
				}
				{
					(this.props.field.field_type === FIELD_TYPE_CPT )
						? <div className="a-field-input a-field-input--cpt"><FieldCpt field={this.props.field} /></div>
						: ''
				}
				{
					(this.props.field.field_type === FIELD_TYPE_DATE )
						? <div className="a-field-input a-field-input--date"><FieldDate field={this.props.field} /></div>
						: ''
				}
				{
					(this.props.field.field_type === FIELD_TYPE_SELECT )
						? <div className="a-field-input a-field-input--select"><FieldSelect field={this.props.field} /></div>
						: ''
				}
				{
					(this.props.field.field_type === FIELD_TYPE_TEXT )
						? <div className="a-field-input a-field-input--text"><FieldText field={this.props.field} /></div>
						: ''
				}
			</div>
		);
	}
}

Field.propTypes = {
	field: PropTypes.object,
};

// Specifies the default values for props:
Field.defaultProps = {
	field: {},
};

export default Field;
