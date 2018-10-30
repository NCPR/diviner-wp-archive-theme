import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactPaginate from 'react-paginate';
import PropTypes from 'prop-types';
import autobind from 'autobind-decorator';

import { setPopupArchiveItem, setPopupVisible, setPage, initiateSearch } from '../actions';

import Item from './item';

class Grid extends Component {

	constructor(props) {
		super(props);
	}

	@autobind
	onSelectItem(e) {
		this.props.onSelectItem(e.id);
	}

	@autobind
	handlePageClick(e) {
		this.props.onChangePage(e.selected + 1);
	}

	getImage(post) {
		let featuredimage = null;
		if (post.feature_image && post.feature_image.sizes) {
			if (post.feature_image.sizes['thumbnail'] && post.feature_image.sizes['thumbnail'].url) {
				featuredimage = post.feature_image.sizes['thumbnail'].url;
			} else if (post.feature_image.sizes.full && post.feature_image.sizes.full.url) {
				featuredimage = post.feature_image.sizes.full.url;
			}
		}
		return featuredimage;
	}

	createItem(post, i) {
		const image = this.getImage(post);
		return (
			<Item
				key={i}
				id={post.id}
				title={post.title.rendered}
				onSelectItem={this.onSelectItem}
				image={image}>
			</Item>
		);
	}

	getItems() {
		return this.props.posts.map(
			(post, i) => this.createItem(post, i)
		);
	}

	handlePageClick(e) {
		this.props.onChangePage(e.selected + 1);
	}

	render() {
		const showPagination = !this.props.isFetching &&
			(this.props.posts._paging && parseInt(this.props.posts._paging.totalPages, 10) > 1);
		let totalPages = 0;
		const currentPage = this.props.page - 1;
		if (showPagination) {
			totalPages = parseInt(this.props.posts._paging.totalPages, 10);
		}
		let label = 'Happy searching!!';
		if (this.props.isFetching) {
			label = 'Loading';
		} else if (this.props.posts.length === 0 && !this.props.posts._paging) {
			label = 'No results found';
		}

		return (
			<div className="a-grid-wrap">
				{
					(this.props.posts.length > 0)
						? <div className="a-grid">{this.getItems()}</div>
						: <div>{label}</div>
				}
				{
					(showPagination)
						? <ReactPaginate
							previousLabel={"previous"}
							nextLabel={"next"}
							breakLabel={<a href="">...</a>}
							breakClassName={"break-me"}
							pageCount={totalPages}
							marginPagesDisplayed={2}
							forcePage={currentPage}
							pageRangeDisplayed={4}
							onPageChange={this.handlePageClick}
							containerClassName={"react-pagination"}
							xsubContainerClassName={"pages pagination"}
							activeClassName={"active"} />
						: null
					}
			</div>
		);
	}
}

// export default Grid;


Grid.propTypes = {
	posts: PropTypes.array.isRequired,
	isFetching: PropTypes.bool.isRequired,
	lastUpdated: PropTypes.number,
	onSelectItem: PropTypes.func,
	onChangePage: PropTypes.func,
	page: PropTypes.number,
};

Grid.defaultProps = {
	posts: [],
	isFetching: false,
	page: 0,
	onSelectItem: () => {},
	onChangePage: () => {},
};

function mapStateToProps(state) {
	const { postsByCacheKey, currentCacheKey } = state;
	const {
		isFetching,
		lastUpdated,
		items: posts
	} = postsByCacheKey[currentCacheKey] || {
		isFetching: true,
		items: []
	};

	return {
		posts,
		isFetching,
		lastUpdated,
		page: state.page,
	};
}

/**
 * mapDispatchToProps
 *
 * Mapping property to dispatches
 */
const mapDispatchToProps = (dispatch) => ({
	onSelectItem: (value) => {
		dispatch(setPopupArchiveItem(value));
		dispatch(setPopupVisible(true));
	},
	onChangePage: (value) => {
		dispatch(setPage(value));
		dispatch(initiateSearch());
	}
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(Grid);
