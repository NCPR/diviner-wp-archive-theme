
const WPAPI = require('wpapi');
import _ from 'lodash';
import history from '../utils/data/history';

import stateToParameters from '../utils/stateToParameters';
import { SETTINGS, FIELD_PROP_FIELD_ID, FIELD_PROP_FIELD_TYPE, FIELD_TYPE_TAXONOMY, FIELD_PROP_TAXONOMY_NAME } from '../config/settings';
import { CONFIG } from '../globals/config';
import objectToParameters from '../utils/data/object-to-params';
import getParams from '../utils/data/query-to-obj';
import { termsToSelectOptions } from '../utils/wp/termsToSelectOptions';
import { getFieldTypeFromId } from '../utils/data/field-utils';

const site = new WPAPI({
	endpoint: '/wp-json'
});


const params = [
	'taxonomyThing'
];
CONFIG.fields.forEach((field)=> {
	if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_TAXONOMY) {
		params.push(field[FIELD_PROP_TAXONOMY_NAME]);
	} else {
		params.push(field[FIELD_PROP_FIELD_ID]);
	}

});

params.push('test');

console.log('params', params);

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
export const SET_DONOR_FILTER = 'SET_DONOR_FILTER';
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

// items: store.getState().otherReducer.items,
function fetchPosts(cacheKey) {
	console.log('fetchPosts', cacheKey);
	return (dispatch, getState) => {
		dispatch(requestPosts(cacheKey));
		const archivalQuery = site.archivalItems();

		// change URL
		const obj = {};

		/*
		if (getState().orderBy) {
			archivalQuery.custom_order(getState().orderBy);
			obj.pOrder = getState().orderBy;
		}
		*/

		const fieldData = getState().fieldData;
		console.log('fieldData', fieldData);

		if (!_.isEmpty(fieldData)) {
			// console.log('archivalQuery', archivalQuery);
			_.forOwn(getState().fieldData, (value, key) => {
				console.log('field Data state', value, key);
				// if taxonomy or multi select then create array of IDs
				const field = getFieldTypeFromId(key);
				console.log('field', field);
				if (field[FIELD_PROP_FIELD_TYPE]===FIELD_TYPE_TAXONOMY) {
					//const tagIDs = _.map(value, (item) => item.value);
					const taxName = field[FIELD_PROP_TAXONOMY_NAME];
					console.log('taxName', taxName);
					console.log('key', key);
					archivalQuery[taxName](value);
					// archivalQuery['divinerTaxonomyField152'](value);

					// archivalQuery.diviner_taxonomy_field_152(value);


					//archivalQuery[key](value);

					// archivalQuery['taxonomyThing'](value);


					/*
					console.log(Object.getOwnPropertyNames(archivalQuery).filter(function (p) {
						return typeof archivalQuery[p] === 'function';
					}));
					*/

				} else {
					archivalQuery[key](value);
				}

				obj[key] = value;
			});

			// getState().fieldData.forEach((fieldData) => {
				// to do... change the query
			//})

			// const countyIDs = _.map(getState().countyFilter, (item) => item.value);
			// archivalQuery.county(countyIDs);
			// obj.pCounty = countyIDs;
		}


		/*
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
		*/

		archivalQuery.test('something');

		if (getState().queryString.length) {
			archivalQuery.search(getState().queryString);
			obj.search = getState().queryString;
		}

		// pagination
		archivalQuery.perPage(SETTINGS.postsPerPage);
		archivalQuery.page(getState().page);

		obj.pPage = getState().page;

		const param = objectToParameters(obj);
		const path = `/browse/?${param}`;
		history.push(path);

		console.log('obj', obj);

		archivalQuery.then((data) => {
			console.log('data', data);
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
		console.log('key', key);
		dispatch(setCacheKey(key));
		// dispatch(invalidateSearchQuery(key));
		dispatch(fetchPostsIfNeeded(key));
	};
}

export function startApp(location) {
	return (dispatch) => {
		/*
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
		*/

		dispatch(initiateSearch());
	};
}

export function clearFacets() {
	return (dispatch) => {
		// reset facets
		dispatch(setFieldData({}));
		dispatch(setPage(1));
		dispatch(initiateSearch());
	};
}
