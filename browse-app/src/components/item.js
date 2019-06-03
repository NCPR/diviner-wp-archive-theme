import React, { Component } from 'react';
import PropTypes from 'prop-types';
import LazyLoad from 'react-lazy-load';

import {
	DIV_AI_TYPE_VIDEO,
	DIV_AI_TYPE_AUDIO,
	DIV_AI_TYPE_DOCUMENT,
	DIV_AI_TYPE_PHOTO,
	DIV_AI_TYPE_MIXED
} from '../config/settings';
import {REQUEST_POSTS} from "../actions";


class Item extends Component {

	constructor(props) {
		super(props);
		this.onClick = this.onClick.bind(this);
	}

	componentDidMount() {
	}

	onClick() {
		this.props.onSelectItem({
			id: this.props.id,
			title: this.props.title,
		});
	}

	getImage() {
		if (this.props.image) {
			return(
				<LazyLoad>
					<img src={this.props.image} />
				</LazyLoad>
			);
		}
		return ('');
	}

	render() {
		let itemClass = 'a-item';
		const image = this.getImage();
		if (!image) {
			itemClass += ` a-item--no-feature-image`;
		}
		itemClass += ` a-item--type-${this.props.type}`;

		return (
			<div className={itemClass}>
				<div className="a-item__action" onClick={this.onClick}>
					<div className="a-item__figure">
						<div className="a-item__img">
							{image}
						</div>
						<div
							className="a-item__figure-caption"
							dangerouslySetInnerHTML={{ __html: this.props.title }}>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

Item.propTypes = {
	id: PropTypes.number,
	title: PropTypes.string,
	type: PropTypes.string,
	onSelectItem: PropTypes.func,
};

Item.defaultProps = {
	onSelectItem: () => {},
};

export default Item;
