import { combineReducers } from 'redux';

import { postsByCacheKey, showArrows } from './posts';
import currentCacheKey from './currentCacheKey';
import page from './pagination';
import queryString from './queryString';
import filterOpen from './filterOpen';
import fieldData from './fieldData';
import orderBy from './orderBy';
import { currentPopupPostId, popupVisible } from './currentPopupPostId';

const facetApp = combineReducers({
	currentCacheKey,
	showArrows,
	orderBy,
	fieldData,
	page,
	queryString,
	postsByCacheKey,
	filterOpen,
	currentPopupPostId,
	popupVisible
});


export default facetApp;
