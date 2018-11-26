
import { SET_FIELD_DATA } from '../actions';
import { CONFIG } from '../globals/config';

const getInitialState = function() {
	const state = {};
	CONFIG.fields.forEach((field) => {
		state[field.field_id] = '';
	})
	return state;
};

const initialState = getInitialState();

const fieldData = (state = initialState, action) => {
	switch (action.type) {
		case SET_FIELD_DATA:
			return action.value;
		default:
			return state;
	}
};

export default fieldData;
