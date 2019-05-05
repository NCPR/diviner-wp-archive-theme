
const WPAPI = require('wpapi');
import _ from 'lodash';
import history from '../utils/data/history';

import stateToParameters from '../utils/stateToParameters';
import {
	SETTINGS,
	FIELD_PROP_FIELD_ID,
	FIELD_PROP_FIELD_TYPE,
	FIELD_TYPE_TAXONOMY,
	FIELD_PROP_TAXONOMY_NAME,
	FIELD_TYPE_DATE, FIELD_TYPE_TEXT
} from '../config/settings';
import { CONFIG } from '../globals/config';
import objectToParameters from '../utils/data/objectToParams';
import { getFieldTypeFromId } from '../utils/data/fieldUtils';
import { lock, unlock } from '../utils/dom/bodyLock';
import { isPlainPermalinkStructure } from '../utils/data/permalinks';

const site = new WPAPI({
	endpoint: isPlainPermalinkStructure() ? '?rest_route=' : '/wp-json'
});

const params = [
	'order_by',
];
CONFIG.fields.forEach((field)=> {
	if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_TAXONOMY) {
		params.push(field[FIELD_PROP_TAXONOMY_NAME]);
	} else {
		params.push(field[FIELD_PROP_FIELD_ID]);
	}
});

site.archivalItems = site.registerRoute(
	'wp/v2',
	'/archival-items/(?P<query>)', {
		// Listing any of these parameters will assign the built-in
		// chaining method that handles the parameter:
		params: params
	}
);

if (process.env.NODE_ENV!=='production') {
	WPAPI.discover('/')
		.then((siteDetails) => {
		console.info('siteDetails', siteDetails);
	});
}

export const INVALIDATE_SEARCH_QUERY = 'INVALIDATE_SEARCH_QUERY';
export const REQUEST_POSTS = 'REQUEST_POSTS';
export const RECEIVE_POSTS = 'RECEIVE_POSTS';
export const SET_QUERY_STRING = 'SET_QUERY_STRING';
export const SET_CACHE_KEY = 'SET_CACHE_KEY';
export const SET_POPUP_ID = 'SET_POPUP_ID';
export const SET_POPUP_VISIBLE = 'SET_POPUP_VISIBLE';
export const SET_ORDER_BY = 'SET_ORDER_BY';
export const SET_TAG_FILTER = 'SET_TAG_FILTER';
export const SET_YEAR_RANGE_FILTER = 'SET_YEAR_RANGE_FILTER';
export const SET_DATE_FILTER = 'SET_DATE_FILTER';
export const SET_PAGE = 'SET_PAGE';
export const CLEAR_FACETS = 'CLEAR_FACETS';
export const SET_MOBILE_FILTER_OPEN = 'SET_MOBILE_FILTER_OPEN';
export const SET_FIELD_DATA = 'SET_FIELD_DATA';

export function setFieldData(value) {
	return {
		type: SET_FIELD_DATA,
		value
	};
}

export function setMobileFilter(value) {
	return {
		type: SET_MOBILE_FILTER_OPEN,
		value
	};
}

export function toggleClick() {
	return (dispatch, getState) => {
		dispatch(setMobileFilter(!getState().filterOpen));
	};
}

export function setPage(value) {
	return {
		type: SET_PAGE,
		value
	};
}

export function setOrderBy(value) {
	return {
		type: SET_ORDER_BY,
		value
	};
}

export function setPopupVisible(isVisible) {
	if (isVisible) {
		lock();
	} else {
		unlock();
	}
	return {
		type: SET_POPUP_VISIBLE,
		value: isVisible
	};
}

export function setPopupArchiveItem(id) {
	return {
		type: SET_POPUP_ID,
		id
	};
}

export function sequencePopupArchiveItem(increment) {
	return (dispatch, getState) => {
		// current id
		const currentId = getState().currentPopupPostId;
		const posts = getState().postsByCacheKey[getState().currentCacheKey];
		let currentIndex = -1;

		posts.items.forEach((post, index) => {
			if (post.id === currentId) {
				currentIndex = index;
			}
		});

		if (currentIndex !== -1) {
			currentIndex = currentIndex + increment;
			if (currentIndex < 0) {
				currentIndex = posts.items.length - 1;
			}
			if (currentIndex >= posts.items.length) {
				currentIndex = 0;
			}
			dispatch(setPopupArchiveItem(posts.items[currentIndex].id));
		}
	};
}

export function setCacheKey(value) {
	return {
		type: SET_CACHE_KEY,
		value
	};
}


export function setQueryString(value) {
	return {
		type: SET_QUERY_STRING,
		value
	};
}

export function invalidateSearchQuery(cacheKey) {
	return {
		type: INVALIDATE_SEARCH_QUERY,
		cacheKey
	};
}

function requestPosts(cacheKey) {
	return {
		type: REQUEST_POSTS,
		cacheKey
	};
}

function receivePosts(cacheKey, json) {
	return {
		type: RECEIVE_POSTS,
		cacheKey,
		posts: json,
		receivedAt: Date.now()
	};
}

const getParamsObjectFromState = (getState) => {
	const obj = {};
	if (getState().orderBy) {
		obj.order_by = getState().orderBy;
	}

	const fieldData = getState().fieldData;
	if (!_.isEmpty(fieldData) ) {
		_.forOwn(getState().fieldData, (value, key) => {
			obj[key] = value;
		});
	}

	if (getState().queryString.length) {
		obj.search = getState().queryString;
	}
	obj.pPage = getState().page;
	return obj;
};

const updateHistory = (getState) => {
	const obj = getParamsObjectFromState(getState);
	const param = objectToParameters(obj);
	const path = isPlainPermalinkStructure() ? `${CONFIG.base_browse_url}&${param}` : `${CONFIG.base_browse_url}/?${param}`;
	history.push(path);
};

// items: store.getState().otherReducer.items,
function fetchPosts(cacheKey) {
	return (dispatch, getState) => {
		dispatch(requestPosts(cacheKey));

		const archivalQuery = site.archivalItems();

		if (getState().orderBy) {
			archivalQuery.order_by(getState().orderBy);
		}

		const fieldData = getState().fieldData;
		if (!_.isEmpty(fieldData) ) {
			_.forOwn(getState().fieldData, (value, key) => {
				// if taxonomy or multi select then create array of IDs
				const field = getFieldTypeFromId(key);
				if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_TAXONOMY) {
					const taxName = field[FIELD_PROP_TAXONOMY_NAME];
					archivalQuery[taxName](value);
				} else if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_DATE) {
					if (value && value.length && value[0] && value[1]) {
						archivalQuery[key](value);
					}
				} else if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_TEXT) {
					archivalQuery[key](value);
				} else {
					archivalQuery[key](value);
				}
			});
		}

		if (getState().queryString.length) {
			archivalQuery.search(getState().queryString);
		}

		// pagination
		archivalQuery.perPage(SETTINGS.postsPerPage);
		archivalQuery.page(getState().page);

		updateHistory(getState);

		archivalQuery.then((data) => {
			dispatch(receivePosts(cacheKey, data));
		}).catch((err) => {
			// handle error
			console.info('ERROR', err);
		});
	};
}

function shouldFetchPosts(state, cacheKey) {
	const posts = state.postsByCacheKey[cacheKey];
	if (!posts) {
		return true;
	} else if (posts.isFetching) {
		return false;
	}
	return posts.didInvalidate;
}

export function fetchPostsIfNeeded(cacheKey) {
	return (dispatch, getState) => {
		if (shouldFetchPosts(getState(), cacheKey)) {
			return dispatch(fetchPosts(cacheKey));
		} else {
			// still need to create a history entry and update the path
			updateHistory(getState);
		}
		return null;
	};
}

export function selectGridItem(value) {
	// create cache path from parameters
	return (dispatch, getState) => {
		if (CONFIG.settings.display_popup){
			dispatch(setPopupArchiveItem(value));
			dispatch(setPopupVisible(true));
		} else {
			const posts = getState().postsByCacheKey[getState().currentCacheKey];
			const post = _.find(posts.items, {id: value});
			if (post.permalink) {
				location.href = post.permalink;
			}
		}
	};
}

export function initiateSearch() {
	// create cache path from parameters
	return (dispatch, getState) => {
		const key = stateToParameters(getState());
		dispatch(setCacheKey(key));
		// dispatch(invalidateSearchQuery(key));
		dispatch(fetchPostsIfNeeded(key));
	};
}

export function startApp(location) {
	return (dispatch) => {
		dispatch(initiateSearch());
	};
}

export function clearFacets() {
	return (dispatch) => {
		// reset facets
		const fieldData = {};
		CONFIG.fields.forEach((field)=> {
			fieldData[field[FIELD_PROP_FIELD_ID]] = '';
		});
		dispatch(setFieldData(fieldData));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	};
}
