
const WPAPI = require('wpapi');
import _ from 'lodash';
import history from '../utils/data/history';

import stateToParameters from '../utils/stateToParameters';
import { SETTINGS } from '../config/settings';
import { CONFIG } from '../globals/config';
import objectToParameters from '../utils/data/object-to-params';
import getParams from '../utils/data/query-to-obj';
import { termsToSelectOptions } from '../utils/wp/termsToSelectOptions';

const site = new WPAPI({
	endpoint: '/wp-json'
});

site.archivalItems = site.registerRoute(
	'wp/v2',
	'/archival-items/(?P<query>)', {
		// Listing any of these parameters will assign the built-in
		// chaining method that handles the parameter:
		params: [
			'decade',
			'workType',
			'county',
			'location',
			'institution',
			'donor',
			'year',
			'custom_order',
			'date_range',
			'tags'
		]
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
export const SET_DECADE_FILTER = 'SET_DECADE_FILTER';
export const SET_WORK_TYPE_FILTER = 'SET_WORK_TYPE_FILTER';
export const SET_COUNTY_FILTER = 'SET_COUNTY_FILTER';
export const SET_LOCATION_FILTER = 'SET_LOCATION_FILTER';
export const SET_INSTITUTION_FILTER = 'SET_INSTITUTION_FILTER';
export const SET_QUERY_STRING = 'SET_QUERY_STRING';
export const SET_CACHE_KEY = 'SET_CACHE_KEY';
export const SET_POPUP_ID = 'SET_POPUP_ID';
export const SET_POPUP_VISIBLE = 'SET_POPUP_VISIBLE';
export const SET_ORDER_BY = 'SET_ORDER_BY';
export const SET_TAG_FILTER = 'SET_TAG_FILTER';
export const SET_YEAR_RANGE_FILTER = 'SET_YEAR_RANGE_FILTER';
export const SET_DATE_FILTER = 'SET_DATE_FILTER';
export const SET_DONOR_FILTER = 'SET_DONOR_FILTER';
export const SET_PAGE = 'SET_PAGE';
export const CLEAR_FACETS = 'CLEAR_FACETS';
export const SET_MOBILE_FILTER_OPEN = 'SET_MOBILE_FILTER_OPEN';

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

export function setDateFilter(value) {
	return {
		type: SET_DATE_FILTER,
		value
	};
}

export function setTagsFilter(value) {
	return {
		type: SET_TAG_FILTER,
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

export function setWorkTypeFilter(value) {
	return {
		type: SET_WORK_TYPE_FILTER,
		value
	};
}

export function setCountyFilter(value) {
	return {
		type: SET_COUNTY_FILTER,
		value
	};
}

export function setDonorFilter(value) {
	return {
		type: SET_DONOR_FILTER,
		value
	};
}

export function setInstitutionFilter(value) {
	return {
		type: SET_INSTITUTION_FILTER,
		value
	};
}

export function setLocationFilter(value) {
	return {
		type: SET_LOCATION_FILTER,
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

// items: store.getState().otherReducer.items,
function fetchPosts(cacheKey) {
	return (dispatch, getState) => {
		dispatch(requestPosts(cacheKey));
		const archivalQuery = site.archivalItems();

		// change URL
		const obj = {};

		if (getState().orderBy) {
			archivalQuery.custom_order(getState().orderBy);
			obj.pOrder = getState().orderBy;
		}

		if (getState().dateFilter.length) {
			archivalQuery.date_range(getState().dateFilter);
			obj.pDate = getState().dateFilter;
		}

		if (getState().countyFilter.length) {
			const countyIDs = _.map(getState().countyFilter, (item) => item.value);
			archivalQuery.county(countyIDs);
			obj.pCounty = countyIDs;
		}
		if (getState().workTypeFilter.length) {
			// archivalQuery.workType(getState().workTypeFilter);
			const workIDs = _.map(getState().workTypeFilter, (item) => item.value);
			archivalQuery.workType(workIDs);
			obj.pWorkType = workIDs;
		}
		if (getState().locationFilter) {
			archivalQuery.location(getState().locationFilter);
			obj.pLocation = getState().locationFilter;
		}
		if (getState().institutionFilter) {
			archivalQuery.institution(getState().institutionFilter);
			obj.pInstitution = getState().institutionFilter;
		}
		if (getState().donorFilter) {
			archivalQuery.donor(getState().donorFilter);
			obj.pDonor = getState().donorFilter;
		}
		if (getState().queryString.length) {
			archivalQuery.search(getState().queryString);
			obj.search = getState().queryString;
		}

		// pagination
		archivalQuery.perPage(SETTINGS.postsPerPage);
		archivalQuery.page(getState().page);

		obj.pPage = getState().page;

		if (getState().tagsFilter.length) {
			// get IDs
			const tagIDs = _.map(getState().tagsFilter, (item) => item.value);
			archivalQuery.tags(tagIDs);
			obj.tags = tagIDs;
		}

		const param = objectToParameters(obj);
		const path = `/browse/?${param}`;
		history.push(path);

		archivalQuery.then((data) => {
			// console.log('data', data);
			// console.log('header: ' , data.headers['x-wp-totalpages']);
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
		}
		return null;
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
		if (location.search && location.search.length && location.search.indexOf('?') === 0) {
			const params = location.search.substr(1);
			const obj = getParams(params);

			if (obj.pOrder) {
				dispatch(setOrderBy(obj.pOrder));
			}

			if (obj.search) {
				dispatch(setQueryString(obj.search));
			}

			if (obj.pWorkType) {
				const workIDs = obj.pWorkType.split(',');
				const workTypes = _.filter(CONFIG.work_types, (item) => {
					if (_.includes(workIDs, item.term_id.toString())) {
						return item;
					}
					return null;
				});
				const workTypesSel = termsToSelectOptions(workTypes);
				dispatch(setWorkTypeFilter(workTypesSel));
			}

			if (obj.pCounty) {
				const countyIDs = obj.pCounty.split(',');
				const countyTypes = _.filter(CONFIG.counties, (item) => {
					if (_.includes(countyIDs, item.term_id.toString())) {
						return item;
					}
					return null;
				});
				const countyTypesSel = termsToSelectOptions(countyTypes);
				dispatch(setCountyFilter(countyTypesSel));
			}

			if (obj.pLocation) {
				dispatch(setLocationFilter(parseInt(obj.pLocation, 10)));
			}

			if (obj.pInstitution) {
				dispatch(setInstitutionFilter(parseInt(obj.pInstitution, 10)));
			}

			if (obj.pDonor) {
				dispatch(setDonorFilter(parseInt(obj.pDonor, 10)));
			}

			if (obj.pDate) {
				const dateArr = obj.pDate.split(',');
				const dateArrInts = [];
				dateArr.forEach((part, index) => {
					dateArrInts[index] = parseInt(part, 10);
				});
				dispatch(setDateFilter(dateArrInts));
			}

			if (obj.tags) {
				const tagIDs = obj.tags.split(',');
				const tagTypes = _.filter(CONFIG.tags, (item) => {
					if (_.includes(tagIDs, item.term_id.toString())) {
						return item;
					}
					return null;
				});
				const tagTypesSel = termsToSelectOptions(tagTypes);
				dispatch(setTagsFilter(tagTypesSel));
			}

			if (obj.pPage) {
				dispatch(setPage(parseInt(obj.pPage, 10)));
			}
		}

		dispatch(initiateSearch());
	};
}

export function clearFacets() {
	return (dispatch) => {
		dispatch(setCountyFilter([]));
		dispatch(setWorkTypeFilter([]));
		dispatch(setLocationFilter(null));
		dispatch(setDonorFilter(null));
		dispatch(setTagsFilter([]));
		dispatch(setInstitutionFilter(null));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	};
}
