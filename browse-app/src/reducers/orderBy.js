
import { SET_ORDER_BY } from '../actions';
import { CONFIG } from '../globals/config';

let initialState = '';

const countyFilter = (state = initialState, action) => {
	switch (action.type) {
		case SET_ORDER_BY:
			return action.value;
		default:
			return state;
	}
};

export default countyFilter;
