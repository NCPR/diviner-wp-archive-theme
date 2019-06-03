
import { SET_PAGE } from '../actions';

const page = (state = 1, action) => {
	switch (action.type) {
		case SET_PAGE:
			return action.value;
		default:
			return state;
	}
};

export default page;
