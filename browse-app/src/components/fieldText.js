import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';

import {
	initiateSearch,
	setPage,
	setFieldData,
} from '../actions';

import { TEXT_FIELD_COUNT_MINIMUM } from '../config/options';

class FieldText extends Component {

	constructor(props) {
		super(props);
		this.state = {
			value: this.getInitalValue(props)
		};
	}

	@autobind
	onChangeField(e) {
		const prevValue = this.state.value;
		this.setState({
			value: e.currentTarget.value
		});
		if (e.currentTarget.value.length >= TEXT_FIELD_COUNT_MINIMUM) {
			const newData = _.cloneDeep(this.props.fieldData);
			newData[this.props.field.field_id] = e.currentTarget.value;
			this.props.onChangeFacets(newData, e.currentTarget.value);
		} else {
			if (prevValue.length >= TEXT_FIELD_COUNT_MINIMUM) {
				const newData = _.cloneDeep(this.props.fieldData);
				newData[this.props.field.field_id] = '';
				this.props.onChangeFacets(newData, e.currentTarget.value);
			}
		}
	}

	getInitalValue(props) {
		return props.fieldData[props.field.field_id] ? props.fieldData[props.field.field_id] : '';
	}

	createField() {
		return (
			<input
				type="text"
				onChange={this.onChangeField}
				value={this.state.value}
			/>
		);
	}

	render() {
		if (!this.props.field) {
			return '';
		}
		return (
			<div className="a-field">
				<label>{ this.props.field.title }</label>
				<div className="a-field-input a-field-input--text">{this.createField()}</div>
				<small className="a-input-description">{ this.props.field.helper }</small>
			</div>
		);
	}
}

FieldText.propTypes = {
	field: PropTypes.object,
	fieldData: PropTypes.object,
	onChangeFacets: PropTypes.func,
};

// Specifies the default values for props:
FieldText.defaultProps = {
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
	onChangeFacets: (value, newTextValue) => {
		dispatch(setFieldData(value));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	},
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(FieldText);