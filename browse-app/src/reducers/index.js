import { combineReducers } from 'redux';

import page from './pagination';


const facetApp = combineReducers({
	page,
});

export default facetApp;
