import React, { Component } from 'react';
import PropTypes from 'prop-types';
import LazyLoad from 'react-lazy-load';

import {
	DIV_AI_TYPE_VIDEO,
	DIV_AI_TYPE_AUDIO
} from '../config/settings';


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
		if (this.props.type === DIV_AI_TYPE_AUDIO) itemClass += ' a-item--has-audio';
		if (this.props.type === DIV_AI_TYPE_VIDEO) itemClass += ' a-item--has-video';

		return (
			<div className={itemClass}>
				<div className="a-item__action" onClick={this.onClick}>
					<div className="a-item__figure">
						<div className="a-item__img">
							{this.getImage()}
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
