import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from 'lodash';
import autobind from 'autobind-decorator';
import { connect } from 'react-redux';
import { format } from 'date-fns';
import { Calendar } from 'react-date-range';

import 'react-date-range/dist/styles.css'; // main style file
import 'react-date-range/dist/theme/default.css'; // theme css file

import ASlider from './aslider';

import {
	FIELD_DATE_TYPE,
	FIELD_DATE_START,
	FIELD_DATE_END,
	FIELD_DATE_TYPE_CENTURY,
	FIELD_DATE_TYPE_YEAR,
	FIELD_DATE_TYPE_DECADE,
	FIELD_DATE_TYPE_TWO_DATE,
	FIELD_DATE_MIN_YEAR_DEFAULT,
	FIELD_DATE_MAX_YEAR_DEFAULT
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
		super(props);
		_this = this;

		this.state = {
			calendarStartVisible: false,
			calendarEndVisible: false,
			currentCalendar: null,
		};
		this.myRef = React.createRef();
		this.dateStartRef = React.createRef();
		this.dateEndRef = React.createRef();
		this.calendarStartRef = React.createRef();
		this.calendarEndRef = React.createRef();
	}

	componentDidMount() {
		document.addEventListener('mousedown', this.onClickBody);
	}

	componentWillUnmount() {
		document.removeEventListener('mousedown', this.onClickBody);
	}

	@autobind
	onClickBody(e) {
		const { target } = e;
		if (this.state.calendarStartVisible || this.state.calendarEndVisible) {
			if (this.state.calendarStartVisible &&
				this.calendarStartRef &&
				!this.calendarStartRef.current.contains(target) &&
				this.dateStartRef.current !== target) {
				this.setState({
					calendarStartVisible: false
				});
				return false;
			} else if(this.state.calendarEndVisible &&
				this.calendarEndRef &&
				!this.calendarEndRef.current.contains(target) &&
				this.dateEndRef.current !== target) {
				this.setState({
					calendarEndVisible: false
				});
				return false;
			}

		}
		return true;
	}

	@autobind
	onChangeDateSliderField(e) {
		const newData = _.cloneDeep(_this.props.fieldData);
		const dateArray = this.getDateArrayFromSliderValue(e.value);
		newData[e.id] = dateArray;
		this.props.onChangeFacets(newData);
	}

	@autobind
	onChangeStartDate(e) {
		const newData = _.cloneDeep(this.props.fieldData);
		let currentArray = newData[this.props.field.field_id];
		const newValue = format(new Date(e), 'YYYY/MM/DD', { awareOfUnicodeTokens: true });
		if (currentArray.length) {
			currentArray[0] = newValue;
		} else {
			currentArray = [
				newValue,
				''
			]
		}
		newData[this.props.field.field_id] = currentArray;
		this.setState({
			calendarStartVisible: false
		});
		this.props.onChangeFacets(newData);
	}

	@autobind
	onChangeEndDate(e) {
		const newData = _.cloneDeep(this.props.fieldData);
		let currentArray = newData[this.props.field.field_id];
		const newValue = format(new Date(e), 'YYYY/MM/DD', { awareOfUnicodeTokens: true });
		if (currentArray.length) {
			currentArray[1] = newValue;
		} else {
			currentArray = [
				'',
				newValue
			]
		}
		newData[this.props.field.field_id] = currentArray;
		this.setState({
			calendarEndVisible: false
		});
		this.props.onChangeFacets(newData);
	}

	@autobind
	onToggleStartVisibility(e) {
		const nextCurr = !this.state.calendarStartVisible ? this.dateStartRef : null;
		this.setState({
			calendarStartVisible: !this.state.calendarStartVisible,
			currentCalendar: nextCurr
		});
	}

	@autobind
	onToggleEndVisibility(e) {
		const nextCurr = !this.state.calendarEndVisible ? this.dateEndRef : null;
		this.setState({
			calendarEndVisible: !this.state.calendarEndVisible,
			currentCalendar: nextCurr
		});
	}

	getDateArrayFromSliderValue(sliderValue) {
		if (!sliderValue.length) {
			return [];
		}
		return [
			`${sliderValue[0]}/1/1`,
			`${sliderValue[1]}/1/1`
		]
	}

	getMinYear(field) {
		if (field[FIELD_DATE_START]) {
			return this.getYearFromDate(field[FIELD_DATE_START])
		}
		return FIELD_DATE_MIN_YEAR_DEFAULT;
	}

	getMaxYear(field) {
		if (field[FIELD_DATE_END]) {
			return this.getYearFromDate(field[FIELD_DATE_END])
		}
		return FIELD_DATE_MAX_YEAR_DEFAULT;
	}

	getYearFromDate(date) {
		const nextDate = new Date(date.substring(0, 4));
		return nextDate.getFullYear();
	}

	formatDateDisplay(date, defaultText) {
		if (!defaultText) {
			defaultText = '';
		}
		if (!date) return defaultText;
		return format(date, 'MM/DD/YYYY', { awareOfUnicodeTokens: true });
	}

	createDateRangeInputFields(field) {
		let calendarStartClasses = 'a-date-selector ';
		calendarStartClasses += this.state.calendarStartVisible ? 'a-date-selector--visible' : '';

		let calendarEndClasses = 'a-date-selector ';
		calendarEndClasses += this.state.calendarEndVisible ? 'a-date-selector--visible' : '';

		const values = this.props.fieldData[field.field_id];
		let startDate = undefined;
		let endDate = undefined;
		if (values || values.length) {
			if (values[0]) {
				startDate = new Date(values[0]);
			}
			if (values[1]) {
				endDate = new Date(values[1]);
			}
		}

		return (
			<div>
				<div className="row a-date">
					<div className="gr-6">
						<div>Date Start</div>
						<input
							type="text"
							className="a-input-date a-input-date--range"
							readOnly
							value={this.formatDateDisplay(startDate)}
							ref={this.dateStartRef}
							onClick={this.onToggleStartVisibility}
						/>
						<div
							className={calendarStartClasses}
							ref={this.calendarStartRef}>
							<Calendar
								date={startDate}
								onChange={this.onChangeStartDate}
							/>
						</div>
					</div>

					<div className="gr-6">
						<div>End Start</div>
						<input
							type="text"
							className="a-input-date a-input-date--range"
							readOnly
							value={this.formatDateDisplay(endDate)}
							ref={this.dateEndRef}
							onClick={this.onToggleEndVisibility}
						/>
						<div
							className={calendarEndClasses}
							ref={this.calendarEndRef}>
							<Calendar
								date={endDate}
								onChange={this.onChangeEndDate}
							/>
						</div>
					</div>

				</div>

			</div>

		);
	}

	createDateSliderField(field) {
		let step = 1;
		if (field[FIELD_DATE_TYPE] === FIELD_DATE_TYPE_DECADE) {
			step = 10;
		}
		if (field[FIELD_DATE_TYPE] === FIELD_DATE_TYPE_CENTURY) {
			step = 100;
		}
		const min = this.getMinYear(field);
		const max = this.getMaxYear(field);

		// to do transform into a year range
		let value = this.getValueFormattedForSlider(this.props.fieldData[field.field_id]);
		if (!value || !value.length) {
			value = [min, max];
		}
		return (
			<ASlider
				id={field.field_id}
				min={min}
				max={max}
				step={step}
				value={value}
				onAfterChange={this.onChangeDateSliderField}
			>
			</ASlider>
		);
	}

	getValueFormattedForSlider(originalValue) {
		if (!originalValue || !originalValue.length) {
			return [];
		}
		return _.map(originalValue, (formattedDate) => {
			if (!isNaN(formattedDate)) {
				return formattedDate ;
			}
			return parseInt(formattedDate.substring(0, 4), 10);
		})
	}

	createDateField(field) {
		const typesToUseSlider = [
			FIELD_DATE_TYPE_YEAR,
			FIELD_DATE_TYPE_DECADE,
			FIELD_DATE_TYPE_CENTURY
		];
		if (_.indexOf(typesToUseSlider, field[FIELD_DATE_TYPE]) !== -1 ) {
			return this.createDateSliderField(field);
		}
		// default to 2 date selector
		return this.createDateRangeInputFields(field);
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