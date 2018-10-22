import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import Select from 'react-select';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';

// CONFIG
import { CONFIG } from '../globals/config';
import { FIELD_TYPE_TAXONOMY, FIELD_TYPE_CPT, FIELD_TYPE_TEXT } from '../config/settings';

import { termsToSelectOptions } from '../utils/wp/termsToSelectOptions';
import { postsToSelectOptions } from '../utils/wp/postsToSelectOptions';

import {
	setOrderBy,
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
	onClearClick() {
		console.log('onClearClick');
		this.props.clearFacets();
	}

	@autobind
	onToggleClick() {
		console.log('onToggleClick');
		this.props.onToggleClick();
	}

	onChangeCptField(e) {
		console.log('onChangeCptField', e, _this.props.fieldData);
		const newData = _.cloneDeep(_this.props.fieldData);
		console.log('newData', newData);
		newData[this['data-id']] = e;
		_this.props.onChangeFacets(newData);
	}

	onChangeTaxobomyField(e) {
		console.log('onChangeTaxobomyField', e, _this.props.fieldData);
		const newData = _.cloneDeep(_this.props.fieldData);
		newData[this['data-id']] = e;
		console.log('newData', newData);
		_this.props.onChangeFacets(newData);
	}

	createFields(fields) {
		return fields.map(
			(field, i) => this.createFieldUI(field, i)
		);
	}

	createCptField(field) {
		if (!CONFIG.cpt_posts[field.cpt_field_id]) {
			return '';
		}
		const options = postsToSelectOptions(CONFIG.cpt_posts[field.cpt_field_id]);
		const value = this.props.fieldData[field.field_id];
		console.log('createCptField value', value);
		const clearText = 'Clear '+field.taxonomy_field_singular_label;
		return (
			<Select
				name={field.cpt_field_id}
				clearValueText={clearText}
				data-type={FIELD_TYPE_CPT}
				data-id={field.field_id}
				options={options}
				onChange={this.onChangeCptField}
				value={value}
				></Select>
		);
	}

	createTaxonomyField(field) {
		if (!CONFIG.taxonomies[field.taxonomy_field_name]) {
			return '';
		}
		const options = termsToSelectOptions(CONFIG.taxonomies[field.taxonomy_field_name]);
		const value = this.props.fieldData[field.field_id];
		console.log('createTaxonomyField value', value);
		const clearText = 'Clear '+field.cpt_field_label;
		return (
			<Select
				name={field.taxonomy_field_name}
				data-type={FIELD_TYPE_TAXONOMY}
				data-id={field.field_id}
				clearValueText={clearText}
				options={options}
				onChange={this.onChangeTaxobomyField}
				value={value}
			></Select>
		);
	}

	createFieldUI(field, i) {
		console.log(field);
		if (!field) {
			return '';
		}
		return (
			<div className="a-field" key={i}>
				<label>{ field.title }</label>
				{
					(field.field_type === FIELD_TYPE_TAXONOMY )
						? <div className="a-field-input a-field-input--taxonomy">{this.createTaxonomyField(field)}</div>
						: ''
				}

				{
					(field.field_type === FIELD_TYPE_CPT )
						? <div className="a-field-input a-field-input--cpt">{this.createCptField(field)}</div>
						: ''
				}
				<small className="a-input-description">{ field.helper }</small>
			</div>
		);
	}

	filterFields(fields) {
		return _.map(fields, function(o) {
			if (o && o.position === 'left') return o;
		});
	}

	render() {
		console.log('render');
		console.log('this.props', this.props);

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
		console.log('fieldsOnLeft', fieldsOnLeft);

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
		console.log('onChangeFacet value', value);
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