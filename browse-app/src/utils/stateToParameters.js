
import { CONFIG } from '../globals/config';


// This is a util, it is re-usable and
// it can be invoked as needed by other
// scripts in your app. By itself it
// does nothing :)
export default function stateToParameters(state) {
	console.log('stateToParameters state', state)
	const stringable = {
		base: 'ALL',
		fieldData: {},
		filters: {},
		page: state.page
	};
	if (state.fieldData) {
		// stringable.filters.decade = state.fieldData;

		CONFIG.fields.forEach((field) => {
			if (state.fieldData[field.field_id]) {
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
