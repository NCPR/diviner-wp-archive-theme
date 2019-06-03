/**
 * @module
 * @description Reusable state to parameters utils
 */

import { CONFIG } from '../globals/config';

export default function stateToParameters(state) {
	const stringable = {
		base: 'ALL',
		fieldData: {},
		filters: {},
		page: state.page
	};
	if (state.fieldData) {
		CONFIG.fields.forEach((field) => {
			if (state.fieldData[field.field_id] && state.fieldData[field.field_id]) {
				stringable.filters[field.field_id] = state.fieldData[field.field_id];
			}
		});

	}
	if (state.queryString) {
		stringable.filters.query = state.queryString;
	}
	if (state.orderBy) {
		stringable.orderBy = state.orderBy;
	}

	return JSON.stringify(stringable);
}
