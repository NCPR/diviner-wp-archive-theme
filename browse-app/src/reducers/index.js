import { combineReducers } from 'redux';

import { postsByCacheKey, showArrows } from './posts';
import currentCacheKey from './currentCacheKey';
import page from './pagination';
import queryString from './queryString';


const facetApp = combineReducers({
	currentCacheKey,
	showArrows,
	page,
	queryString,
	postsByCacheKey,
});

export default facetApp;
