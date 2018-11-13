
import { connect } from 'react-redux';
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import _ from "lodash";

import { sequencePopupArchiveItem } from '../actions';
import { CONFIG } from '../globals/config';
import { getTaxonomyItemsFromTermIds, getCPTsFromIds } from "../utils/data/field-utils";

import { FIELD_TYPE_TAXONOMY,
	FIELD_TYPE_CPT,
	FIELD_TYPE_SELECT,
	FIELD_TYPE_DATE,
	FIELD_PROP_DISPLAY_IN_POPUP,
	FIELD_PROP_SELECT_OPTIONS,
	FIELD_PROP_SELECT_OPTIONS_LABEL,
	FIELD_PROP_SELECT_OPTIONS_VALUE,
	IMAGE_SIZE_BROWSE_POPUP,
	FIELD_PROP_TAXONOMY_PLURAL_LABEL,
	FIELD_PROP_FIELD_ID,
	FIELD_PROP_TAXONOMY_NAME,
	FIELD_PROP_CPT_ID,
} from '../config/settings';

/*
{
	"id": 159,
	"title": "Test Select Hair Color",
	"position": "left",
	"helper": "Color of hair",
	"field_id": "select_5bcf191008621",
	"display_in_popup": false,
	"select_field_options": [
	{
		"_type": "_",
		"div_field_select_options_value": "red",
		"div_field_select_options_label": "Red"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "blond",
		"div_field_select_options_label": "Blond"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "black",
		"div_field_select_options_label": "Black"
	},
	{
		"_type": "_",
		"div_field_select_options_value": "brown",
		"div_field_select_options_label": "Brown"
	}
],
	"field_type": "diviner_select_field"
}
*/

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
			if (post.feature_image.sizes[IMAGE_SIZE_BROWSE_POPUP] && post.feature_image.sizes[IMAGE_SIZE_BROWSE_POPUP].url) {
				featuredimage = post.feature_image.sizes[IMAGE_SIZE_BROWSE_POPUP].url;
			} else if (post.feature_image.sizes.full && post.feature_image.sizes.full.url) {
				featuredimage = post.feature_image.sizes.full.url;
			}
		}
		return featuredimage;
	}

	filterFields(fields) {
		return _.filter(fields, (field) => {
			return field[FIELD_PROP_DISPLAY_IN_POPUP] === true;
		});
	}

	renderSeclectField(field) {
		const post = this.props.post;
		const fieldId = field[FIELD_PROP_FIELD_ID];
		if (!post.selects[fieldId]) {
			return;
		}
		const value = post.selects[fieldId];
		const selectObjects = _.filter(field[FIELD_PROP_SELECT_OPTIONS], (option) => {
			return option[FIELD_PROP_SELECT_OPTIONS_VALUE] === value;
		});
		const selectValuesOutput = selectObjects.map((selectValue) => {
			const key = `select-${selectValue[FIELD_PROP_SELECT_OPTIONS_VALUE]}`;
			return (
				<li className="a-sai__list-item a-sai__list-item--select" key={key}>
					{selectValue[FIELD_PROP_SELECT_OPTIONS_LABEL]}
				</li>
			);
		});
		return (
			<div>
				<label className="a-sai__label">
					{field.title}
				</label>
				<ul className="a-sai__list-item a-sai__list-item--select">
					{selectValuesOutput}
				</ul>
			</div>
		);
	}

	renderCPTField(field) {
		const post = this.props.post;
		/* Data structure of post.cpts[field.field_id]
		{
			id: "135"
			subtype: "photographer"
			type: "post"
			value: "post:photographer:135"
		}
		 */
		const fieldId = field[FIELD_PROP_FIELD_ID];
		if (!post.cpts[fieldId]) {
			return;
		}
		const ids = _.map(post.cpts[fieldId], (item) => parseInt(item.id, 10));
		const cptValues = getCPTsFromIds(field[FIELD_PROP_CPT_ID], ids);

		const cptValuesOutput = cptValues.map((cptValue) => {
			const key = `cpt-${cptValue.ID}`;
			return (
				<li className="a-sai__list-item a-sai__list-item--cpt" key={key}>
					{cptValue.post_title}
				</li>
			);
		});
		return (
			<div>
				<label className="a-sai__label">
					{field.title}
				</label>
				<ul className="a-sai__list a-sai__list--cpt">
					{cptValuesOutput}
				</ul>
			</div>
		);
	}

	renderTaxonomyField(field) {
		const post = this.props.post;
		if (!field[FIELD_PROP_TAXONOMY_NAME]) {
			return;
		}
		const taxonomy_name = field[FIELD_PROP_TAXONOMY_NAME];
		if (!post[taxonomy_name] || !post[taxonomy_name].length) {
			return;
		}
		// display a list of the taxonomy terms
		const terms = getTaxonomyItemsFromTermIds(taxonomy_name, post[taxonomy_name]);
		const termsOutput = terms.map((term) => {
			const termKey = `term-${term.term_id}`;
			return (
				<li className="a-sai__list-item a-sai__list-item--taxonomy" key={termKey}>
					{term.name}
				</li>
			);
		});
		return (
			<div>
				<label className="a-sai__label">
					{field[FIELD_PROP_TAXONOMY_PLURAL_LABEL]}
				</label>
				<ul className="a-sai__list a-sai__list--taxonomy">
					{termsOutput}
				</ul>
			</div>
		);
	}

	renderTextField(field) {
		const post = this.props.post;
		const fieldId = field[FIELD_PROP_FIELD_ID];
		const value = post.fields_text[fieldId];
		if (!value) {
			return;
		}
		return (
			<div>
				<label className="a-sai__label">
					{field.title}
				</label>
				<div className="a-sai__value a-sai__value--text">
					{value}
				</div>
			</div>
		);
	}

	renderField(field) {
		let content = '';
		if (field.field_type) {
			if (field.field_type === FIELD_TYPE_SELECT) {
				content = this.renderSeclectField(field);
			} else if (field.field_type === FIELD_TYPE_CPT)  {
				content = this.renderCPTField(field);
			} else if (field.field_type === FIELD_TYPE_TAXONOMY)  {
				content = this.renderTaxonomyField(field);
			} else {
				content = this.renderTextField(field);
			}
		}
		return content;
	}

	renderFields() {
		const fieldsToDisplay = this.filterFields(CONFIG.fields);
		if (!fieldsToDisplay.length) {
			return ('');
		}

		return (
			<div className="row a-row">
				<div className="gr-12">
					<div className="a-sai__fields">
						{fieldsToDisplay.map((field) => {
							let classes = 'a-sai__field ';
							classes += `a-sai__field--${field.field_type}`;
							const fieldRef = `a-sai__field-ref--${field.id}`;
							return (
								<div className={classes} key={fieldRef}>
									{ this.renderField(field) }
								</div>
							);
						})}
					</div>
				</div>
			</div>
		);
	}

	render() {
		const post = this.props.post;
		const imgSrc = this.getImage(post);
		const imgCaption = post.feature_image.caption;
		const rights = CONFIG.settings.permission_notice;
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

				{ this.renderFields() }

				<div className="row a-row">
					<div className="gr-12">
						<a href={post.permalink} className="btn btn-full">View Details</a>
					</div>

					{ // Check for disclaimer
						(rights && rights.length) &&
						<div className="gr-12">
							<div
								className="a-sai__permission"
							>
								<h4 className="a-sai__permission-header">
									Permissions Statement
								</h4>
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
