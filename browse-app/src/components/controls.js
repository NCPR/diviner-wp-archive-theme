
import React, { Component } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

import {
	initiateSearch,
	setQueryString,
	setPage
} from '../actions';

class Controls extends Component {

	constructor(props) {
		super(props);
		this.onClick = this.onClick.bind(this);
		this.searchUpdated = this.searchUpdated.bind(this);
		this.onSearchKeyDown = this.onSearchKeyDown.bind(this);

	}

	searchUpdated(e) {
		this.props.onChangeSearchQuery(e.currentTarget.value);
	}

	onSearchKeyDown(e) {
		if (e.keyCode === 13) {
			this.props.onSubmitSearch();
		}
	}

	onClick(e) {
		e.preventDefault();
		this.props.onSubmitSearch();
	}

	render() {

		const searchString = this.props.searchQuery ? this.props.searchQuery : '';

		return (
			<div className="a-controls">
				<h2 className="a-header-main">Explore Photos</h2>

				<div className="a-input-group a-input-group--controls">
					<label>Search Archive</label>
					<div className="a-search-row">
						<div
							className="a-search-input"
						>
							<input
								type="text"
								onKeyDown={this.onSearchKeyDown}
								onChange={this.searchUpdated}
								placeholder="Ex: cheese factory, grocery store, mine..."
								value={searchString}
							/>
						</div>
						<button
							className="btn a-search-button"
							onClick={this.onClick}
						>
							Go
						</button>
					</div>
				</div>
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
