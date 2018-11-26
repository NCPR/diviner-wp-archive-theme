
import { SET_POPUP_ID, SET_POPUP_VISIBLE } from '../actions';

const initialState = null;

export const currentPopupPostId = (state = initialState, action) => {
	switch (action.type) {
		case SET_POPUP_ID:
			return action.id;
		default:
			return state;
	}
};

export const popupVisible = (state = false, action) => {
	switch (action.type) {
		case SET_POPUP_VISIBLE:
			return action.value;
		default:
			return state;
	}
};

