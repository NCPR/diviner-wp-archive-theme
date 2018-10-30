import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { SkyLightStateless } from 'react-skylight';
import ArchiveItem from './archiveItem';
import { connect } from 'react-redux';

import * as postStore from '../utils/data/posts-store';
import { setPopupVisible, sequencePopupArchiveItem } from '../actions';

const KEY_ARROW_RIGHT = 39;
const KEY_ARROW_LEFT = 37;


class Popup extends Component {

	constructor(props) {
		super(props);
		this.onCloseClicked = this.onCloseClicked.bind(this);
		this.onPreviousClick = this.onPreviousClick.bind(this);
		this.onNextClick = this.onNextClick.bind(this);
		this.onKeyUp = this.onKeyUp.bind(this);
	}

	componentWillMount() {
		document.addEventListener('keyup', this.onKeyUp);
	}

	componentWillUnmount() {
		document.removeEventListener('keyup', this.onKeyUp);
	}

	onKeyUp(e) {
		if (!e.keyCode) {
			return;
		}
		if (e.keyCode === KEY_ARROW_RIGHT) {
			this.props.onNextClick();
		}
		if (e.keyCode === KEY_ARROW_LEFT) {
			this.props.onPreviousClick();
		}
	}

	onPreviousClick() {
		this.props.onPreviousClick();
	}

	onNextClick() {
		this.props.onNextClick();
	}

	onCloseClicked() {
		this.props.onCloseClick();
	}

	_executeBeforeModalOpen() {
		document.body.classList.add('modal--open');
	}

	_executeAfterModalClose() {
		document.body.classList.remove('modal--open');
	}

	render() {
		const post = postStore.getPostsById(this.props.currentPopupPostId);
		const archiveItem = (post) ? (<ArchiveItem post={post} />) : undefined;

		// const archiveItem = ( <div>thing</div> );

		const dialogStyles = {
		};

		const controlStyles = {
		};

		controlStyles.display = this.props.popupPostVisible ? 'block' : 'none';

		if (this.props.popupPostVisible) {
			document.body.classList.add('modal--open');
		} else {
			document.body.classList.remove('modal--open');
		}

		return (
			<div>
				<div className="a-sai__controls" style={controlStyles}>
					<button
						className="a-sai__control-btn a-sai__control-btn--previous"
						onClick={this.onPreviousClick}
					>
						<i className="icon-arrow-left2"></i>
						<span>Previous</span>
					</button>
					<button
						className="a-sai__control-btn a-sai__control-btn--next"
						onClick={this.onNextClick}
					>
						<span>Next</span>
						<i className="icon-arrow-right2"></i>
					</button>
				</div>

				<SkyLightStateless
					isVisible={this.props.popupPostVisible}
					beforeOpen={this._executeBeforeModalOpen}
					afterClose={this._executeAfterModalClose}
					onOverlayClicked={this.onCloseClicked}
					onCloseClicked={this.onCloseClicked}
					dialogStyles={dialogStyles}
					ref="dialogWithCallBacks"
				>
					{archiveItem}
				</SkyLightStateless>
			</div>
		);
	}
}


Popup.propTypes = {
	currentPopupPostId: PropTypes.number,
	popupPostVisible: PropTypes.bool,
	onCloseClick: PropTypes.func,
	onPreviousClick: PropTypes.func,
	onNextClick: PropTypes.func
};

Popup.defaultProps = {
	onCloseClick: () => {},
	onPreviousClick: () => {},
	onNextClick: () => {},
};

const mapStateToProps = (state) => ({
	currentPopupPostId: state.currentPopupPostId,
	popupPostVisible: state.popupVisible,
});

/**
 * mapDispatchToProps
 *
 * Mapping property to dispatches
 */
const mapDispatchToProps = (dispatch) => ({
	onCloseClick: () => dispatch(setPopupVisible(false)),
	onPreviousClick: () => dispatch(sequencePopupArchiveItem(-1)),
	onNextClick: () => dispatch(sequencePopupArchiveItem(1)),
});

export default connect(
	mapStateToProps,
	mapDispatchToProps
)(Popup);
