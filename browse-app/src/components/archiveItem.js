
import { connect } from 'react-redux';
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { sequencePopupArchiveItem } from '../actions';
import { CONFIG } from '../globals/config';

class ArchiveItem extends Component {

	constructor(props) {
		super(props);
		this.handleKeyPress = this.handleKeyPress.bind(this);
		this.handleOnClick = this.handleOnClick.bind(this);
	}

	handleOnClick() {
		location.href = this.props.post.permalink;
	}

	handleKeyPress(event) {
		if (event.nativeEvent.keyCode === 37) {
			this.props.onNextClick();
		}

		if (event.nativeEvent.keyCode === 39) {
			this.props.onPreviousClick();
		}
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

	render() {
		const post = this.props.post;
		const imgSrc = this.getImage(post);
		const imgCaption = post.feature_image.caption;
		//const rights = (post.institution.rights) ? post.institution.rights : CONFIG.permission_notice;
		const rights = "Rights Notice. Lorem Ipsum Something something something something";

		let actionClass = 'a-sai__img-action';

		return (
			<section className="single-archive-item" onKeyDown={this.handleKeyPress}>
				<h4 dangerouslySetInnerHTML={{ __html: post.title.rendered }}></h4>
				{
					(this.props.shouldDisplayArrows) ?
					<div className="a-sai__controls">
					</div>
						: null
				}

				<div className="row a-row">
					<div className="gr-12">
						<div className="a-sai__img-wrap">
							<a href={post.permalink} className={actionClass}>
								<img
								src={imgSrc}
								alt={imgCaption}
								className="a-sai__img"/>
							</a>
						</div>
					</div>
				</div>

				<div className="row a-row">

					<div className="gr-12">
						<a href={post.permalink} className="btn btn-full">View Details</a>
					</div>

					{ // Check for disclaimer
						(rights) &&
						<div className="gr-12">
							<div
								className="a-sai__permission"
							>
								<div className="a-sai__permission-header">
									Permissions Statement
								</div>
								<div
									className="a-sai__permission-content"
									dangerouslySetInnerHTML={{ __html: rights }}
								>
								</div>
							</div>
						</div>
					}

				</div>

			</section>
		);
	}
}

ArchiveItem.propTypes = {
	shouldDisplayArrows: PropTypes.bool,
	onPreviousClick: PropTypes.func,
	onNextClick: PropTypes.func,
	post: PropTypes.object
};

ArchiveItem.defaultProps = {
	shouldDisplayArrows: false,
	onPreviousClick: () => {},
	onNextClick: () => {},
};

const mapStateToProps = (state) => ({ shouldDisplayArrows: state.showArrows });

const mapDispatchToProps = (dispatch) => ({
	onPreviousClick: () => dispatch(sequencePopupArchiveItem(-1)),
	onNextClick: () => dispatch(sequencePopupArchiveItem(1)),
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(ArchiveItem);
