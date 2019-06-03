
import { SET_MOBILE_FILTER_OPEN } from '../actions';

const initialState = false;

const filterOpen = (state = initialState, action) => {
	switch (action.type) {
		case SET_MOBILE_FILTER_OPEN:
			return action.value;
		default:
			return state;
	}
};

export default filterOpen;
