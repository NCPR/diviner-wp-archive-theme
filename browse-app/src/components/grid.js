import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import ReactPaginate from 'react-paginate';

import Item from './item';

class Grid extends Component {

	constructor(props) {
		super(props);
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
				hasAudio={post.has_audio}
				title={post.title.rendered}
				image={post.image}>
			</Item>
		);
	}

	getItems() {
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

export default Grid;
