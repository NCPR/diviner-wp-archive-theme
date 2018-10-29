import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import Select from 'react-select';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';
import Slider from 'rc-slider';
import ASlider from './aslider';
// import styles from 'rc-slider/assets/index.css';


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
			FIELD_DATE_TYPE_CENTURY
} from '../config/settings';

import { termsToSelectOptions } from '../utils/wp/termsToSelectOptions';
import { postsToSelectOptions } from '../utils/wp/postsToSelectOptions';
import { getTaxonomyItemsFromTermIds } from '../utils/data/field-utils';
import { carbonFieldSelectToSelectOptions } from '../utils/wp/carbonFieldSelectToSelectOptions';

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
		this.props.onToggleClick();
	}

	onChangeCptField(e) {
		const newData = _.cloneDeep(_this.props.fieldData);
		console.log('newData', newData);
		if (e === null) {
			newData[this['data-id']] = '';
		} else {
			newData[this['data-id']] = e.value;
		}
		_this.props.onChangeFacets(newData);
	}

	onChangeTaxobomyField(e) {
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

	onChangeSelectField(e) {
		console.log('onChangeSelectField', e);
		const newData = _.cloneDeep(_this.props.fieldData);
		if (e === null) {
			newData[this['data-id']] = [];
		} else {
			// save as array of IDs
			const ids = _.map(e, (item) => item.value);
			newData[this['data-id']] = ids;
		}
		// _this.props.onChangeFacets(newData);
	}

	@autobind
	onChangeDateField(e) {
		console.log('onChangeDateField', e);
		const newData = _.cloneDeep(_this.props.fieldData);
		newData[e.id] = e.value;
		this.props.onChangeFacets(newData);
	}

	createFields(fields) {
		return fields.map(
			(field, i) => this.createFieldUI(field, i)
		);
	}

	getCptSelectItemFromId(cptId, id) {
		return _.find(CONFIG.cpt_posts[cptId], { 'value': id })
	}

	createCptField(field) {
		if (!CONFIG.cpt_posts[field.cpt_field_id]) {
			return '';
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
				onChange={this.onChangeCptField}
				value={valueItem}
				></Select>
		);
	}

	createTaxonomyField(field) {
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
				onChange={this.onChangeTaxobomyField}
				value={valueItems}
			></Select>
		);
	}

	createSelectField(field) {
		console.log('createSelectField');
		if (!field.select_field_options || field.select_field_options.length === 0 ) {
			return '';
		}
		// carbonFieldSelectToSelectOptions
		const value = this.props.fieldData[field.field_id]; // as array id IDs
		const clearText = 'Clear';
		const isClearable = true;
		const options = carbonFieldSelectToSelectOptions(field.select_field_options);
		const valueItems = [];
		return (
			<Select
				name={field.field_id}
				data-type={FIELD_TYPE_SELECT}
				data-id={field.field_id}
				clearValueText={clearText}
				isMulti={false}
				options={options}
				isClearable={isClearable}
				onChange={this.onChangeSelectField}
				value={valueItems}
			></Select>
		);
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

		console.log('min',min);
		console.log('max',max);
		console.log('step',step);

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

	createDateFieldOld(field) {
		console.log('createDateField', field);
		const RangeWithToolTip = Slider.createSliderWithTooltip(Slider.Range);
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

		const defaultValue = [min, max];

		console.log('min',min);
		console.log('max',max);
		console.log('step',step);

		return (
			<div>
				<RangeWithToolTip
					className="a-rc-slider"
					min={min}
					max={max}
					step={step}
					defaultValue={defaultValue}
					onAfterChange={this.onChangeDateField}
					>
						</RangeWithToolTip>
			</div>
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
				{
					(field.field_type === FIELD_TYPE_DATE )
						? <div className="a-field-input a-field-input--date">{this.createDateField(field)}</div>
						: ''
				}
				{
					(field.field_type === FIELD_TYPE_SELECT )
						? <div className="a-field-input a-field-input--select">{this.createSelectField(field)}</div>
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