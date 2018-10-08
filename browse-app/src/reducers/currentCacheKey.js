
import { SET_CACHE_KEY } from '../actions';

const initialState = '';

const currentCacheKey = (state = initialState, action) => {
	switch (action.type) {
		case SET_CACHE_KEY:
			return action.value;
		default:
			return state;
	}
};

export default currentCacheKey;
