import React, { Component } from 'react';
import PropTypes from 'prop-types';

// import LazyLoad from 'react-lazy-load';

console.log('PropTypes', PropTypes);

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
			hasAudio: this.props.hasAudio,
		});
	}

	render() {
		const sectionStyle = {
		};

		if (this.props.image) {
			sectionStyle.backgroundImage = `url(${this.props.image})`;
		}

		let itemClass = 'a-item';
		if (this.props.hasAudio) itemClass += ' a-item--has-audio';

		return (
			<div className={itemClass}>
				<button className="a-item__action" onClick={this.onClick}>
					<div className="a-item__figure">
						<div className="a-item__img">
							<img data-src={this.props.image} className="lazyload" />
						</div>
						<div
							className="a-item__figure-caption"
							dangerouslySetInnerHTML={{ __html: this.props.title }}>
						</div>
					</div>
				</button>
			</div>
		);
	}
}

/*
 <div data-sizes="auto" className="lazyload a-item__image" data-src={this.props.image}></div>

 <LazyLoad>
 <img src={this.props.image} />
 </LazyLoad>


 <div className="a-item__image" style={ sectionStyle }></div>

 <LazyLoad>
 <img src={this.props.image} />
 </LazyLoad>


 data-sizes="auto"
 data-src="http://img.release.1yd.me/Fnq3JmmOan-yAHtJHk-n9-o3Qqbr"
 className="lazyload"

 <div data-sizes="auto" className="lazyload a-item__image" data-src={this.props.image}></div>

 */

Item.propTypes = {
	id: PropTypes.number,
	title: PropTypes.string,
	hasAudio: PropTypes.bool,
	onSelectItem: PropTypes.func,
};

Item.defaultProps = {
	onSelectItem: () => {},
};

export default Item;
