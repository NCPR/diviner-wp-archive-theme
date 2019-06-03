import React, { Component } from 'react';
import PropTypes from 'prop-types';
import autobind from 'autobind-decorator';
import Slider from 'rc-slider';

class ASlider extends Component {

	constructor(props) {
		super(props);
	}

	componentDidMount() {
	}

	@autobind
	onAfterChange(e) {
		this.props.onAfterChange({
			id: this.props.id,
			value: e,
		});
	}

	render() {
		const RangeWithToolTip = Slider.createSliderWithTooltip(Slider.Range);
		return (
			<div className="a-rc-slider">
				<RangeWithToolTip
					min={this.props.min}
					max={this.props.max}
					step={this.props.step}
					defaultValue={this.props.value}
					onAfterChange={this.onAfterChange}
				></RangeWithToolTip>
			</div>
		);
	}
}

ASlider.propTypes = {
	id: PropTypes.string,
	min: PropTypes.number,
	max: PropTypes.number,
	step: PropTypes.number,
	value: PropTypes.array,
	onAfterChange: PropTypes.func,
};

ASlider.defaultProps = {
	id: 'defaultID',
	onAfterChange: () => {},
};

export default ASlider;
