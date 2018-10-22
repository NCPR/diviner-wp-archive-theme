import { combineReducers } from 'redux';

import { postsByCacheKey, showArrows } from './posts';
import currentCacheKey from './currentCacheKey';
import page from './pagination';
import queryString from './queryString';
import filterOpen from './filterOpen';
import fieldData from './fieldData';


const facetApp = combineReducers({
	currentCacheKey,
	showArrows,
	fieldData,
	page,
	queryString,
	postsByCacheKey,
	filterOpen,
});


export default facetApp;
