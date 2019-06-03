
import React, { Component } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import _ from "lodash";
import autobind from 'autobind-decorator';

import Field from './field';
import {
	initiateSearch,
	setQueryString,
	setPage,
} from '../actions';
import { CONFIG } from '../globals/config';
import {
	FIELD_POSITION_TOP,
} from '../config/settings';

// to allow us to access this in the react select component context
let _this;

class Controls extends Component {

	constructor(props) {
		super(props);
		_this = this;
	}

	@autobind
	searchUpdated(e) {
		this.props.onChangeSearchQuery(e.currentTarget.value);
	}

	@autobind
	onSearchKeyDown(e) {
		if (e.keyCode === 13) {
			this.props.onSubmitSearch();
		}
	}

	@autobind
	onClick(e) {
		e.preventDefault();
		this.props.onSubmitSearch();
	}

	filterFields(fields) {
		return _.filter(fields, function(o) {
			return (o && o.position === FIELD_POSITION_TOP);
		});
	}

	createFields(fields) {
		return fields.map(
			(field, i) => {
				if (i < 3) {
					return (
						<Field field={field} key={i} />
					)
				}
				return '';
			}
		);
	}

	render() {
		const searchString = this.props.searchQuery ? this.props.searchQuery : '';
		const fieldsOnTop = this.filterFields(CONFIG.fields);

		const fieldLength = fieldsOnTop.length > 3 ? 3 : fieldsOnTop.length;
		let classes =  'a-control-row ';
		classes += `a-control-row--${fieldLength}`;

		return (
			<div className="a-controls">

				<div className="a-input-group a-input-group--controls">
					<label dangerouslySetInnerHTML={{__html:CONFIG.browse_page_localization.search_header}} />
					<div className="a-search-row">
						<div
							className="a-search-input"
						>
							<input
								type="text"
								onKeyDown={this.onSearchKeyDown}
								onChange={this.searchUpdated}
								placeholder={CONFIG.browse_page_localization.search_placeholder}
								value={searchString}
							/>
						</div>
						<button
							className="btn a-search-button"
							onClick={this.onClick}
							dangerouslySetInnerHTML={{__html:CONFIG.browse_page_localization.search_cta}}
						/>
					</div>
				</div>

				{
					(fieldsOnTop.length > 0)
						? <div className={classes}>{this.createFields(fieldsOnTop)}</div>
						: ''
				}

			</div>
		);
	}
}


Controls.propTypes = {
	isFetching: PropTypes.bool,
	lastUpdated: PropTypes.number,
	dispatch: PropTypes.func,
	searchQuery: PropTypes.string,
	currentKey: PropTypes.string,
	onChangeSearchQuery: PropTypes.func,
	onSubmitSearch: PropTypes.func,
};

Controls.defaultProps = {
	dispatch: () => {},
	searchQuery: '',
	onChangeSearchQuery: () => {},
	onSubmitSearch: () => {},
};

const mapStateToProps = (state) => ({
	isFetching: state.isFetching,
	lastUpdated: state.lastUpdated,
	searchQuery: state.queryString,
	currentKey: state.currentCacheKey,
});

const mapDispatchToProps = (dispatch) => ({
	onChangeDate: (value) => {
		dispatch(setDateFilter(value));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	},
	onChangeSearchQuery: (value) => {
		dispatch(setQueryString(value));
	},
	onSubmitSearch: () => {
		dispatch(setPage(1));
		dispatch(initiateSearch());
	}
});

export default connect(
	mapStateToProps,
	mapDispatchToProps,
)(Controls);
