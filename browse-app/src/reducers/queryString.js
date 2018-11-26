
import { SET_QUERY_STRING } from '../actions';

const initialState = '';

const queryString = (state = initialState, action) => {
	switch (action.type) {
		case SET_QUERY_STRING:
			return action.value;
		default:
			return state;
	}
};

export default queryString;
