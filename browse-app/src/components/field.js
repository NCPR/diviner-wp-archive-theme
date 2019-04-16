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


/**
 * field
 *
 * Renders uot each field based on the below format
 */
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
class Field extends Component {

	render() {
		if (!this.props.field || !this.props.field.field_type) {
			return '';
		}
		let FieldComponent = FieldText;
		let fieldClass = 'a-field-input a-field-input--text';
		switch(this.props.field.field_type) {
			case FIELD_TYPE_TAXONOMY:
				FieldComponent = FieldTaxonomy;
				fieldClass = 'a-field-input a-field-input--taxonomy';
				break;
			case FIELD_TYPE_CPT:
				FieldComponent = FieldCpt;
				fieldClass = 'a-field-input a-field-input--cpt';
				break;
			case FIELD_TYPE_DATE:
				FieldComponent = FieldDate;
				fieldClass = 'a-field-input a-field-input--date';
				break;
			case FIELD_TYPE_SELECT:
				FieldComponent = FieldSelect;
				fieldClass = 'a-field-input a-field-input--select';
				break;
		}
		return (
			<div className="a-input-group">
				<div className={fieldClass}>
					<FieldComponent
						field={this.props.field} ></FieldComponent>
				</div>
			</div>
		);
	}
}


Field.propTypes = {
	field: PropTypes.object,
};

Field.defaultProps = {
	field: {},
};

export default Field;
