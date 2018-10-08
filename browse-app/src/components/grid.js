import React, { Component } from 'react';
import { connect } from 'react-redux';
import ReactPaginate from 'react-paginate';
import PropTypes from 'prop-types'

import { setPopupArchiveItem, setPopupVisible, setPage, initiateSearch } from '../actions';

import Item from './item';

class Grid extends Component {

	constructor(props) {
		super(props);
		this.onSelectItem = this.onSelectItem.bind(this);
		this.handlePageClick = this.handlePageClick.bind(this);
	}


	onSelectItem(e) {
		this.props.onSelectItem(e.id);
	}

	handlePageClick(e) {
		this.props.onChangePage(e.selected + 1);
	}

	getImage(post) {
		let featuredimage = null;
		if (post.feature_image && post.feature_image.sizes) {
			if (post.feature_image.sizes['ncaw-thumb'] && post.feature_image.sizes['ncaw-thumb'].url) {
				featuredimage = post.feature_image.sizes['ncaw-thumb'].url;
			} else if (post.feature_image.sizes.full && post.feature_image.sizes.full.url) {
				featuredimage = post.feature_image.sizes.full.url;
			}
		}
		return featuredimage;
	}

	createItem(post, i) {
		return (
			<Item
				key={i}
				id={post.id}
				XhasAudio={post.has_audio}
				hasAudio={false}
				title={post.title.rendered}
				image={post.image}>
			</Item>
		);
	}

	getItems() {
		return this.props.posts.map(
			(post, i) => this.createItem(post, i)
	);
	}

	getItemsStatic() {
		const posts = [
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			},
			{
				id: 1,
				hasAudio: true,
				title: 'asdh hk adshkas dhksa',
				image: 'http://fpoimg.com/300x250',
			}
		];
		return posts.map(
			(post, i) => this.createItem(post, i)
		);
	}

	handlePageClick(e) {
		this.props.onChangePage(e.selected + 1);
	}

	render() {

		console.log('render this.props.posts', this.props.posts);

		return (
			<div className="a-grid-wrap">
				<div className="row a-grid">{this.getItems()}</div>
				<ReactPaginate
					previousLabel={"previous"}
					nextLabel={"next"}
					breakLabel={<a href="">...</a>}
					breakClassName={"break-me"}
					pageCount={5}
					marginPagesDisplayed={2}
					forcePage={1}
					pageRangeDisplayed={4}
					//onPageChange={this.handlePageClick}
					containerClassName={"react-pagination"}
					activeClassName={"active"} />
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
