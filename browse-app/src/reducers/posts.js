
import {
	INVALIDATE_SEARCH_QUERY,
	REQUEST_POSTS,
	RECEIVE_POSTS
} from '../actions';

import * as postsStore from '../utils/data/postsStore';


function posts(state = {
	isFetching: false,
	didInvalidate: false,
	items: []
}, action) {
	switch (action.type) {
		case INVALIDATE_SEARCH_QUERY:
			return Object.assign({}, state, {
				didInvalidate: true
			});
		case REQUEST_POSTS:
			return Object.assign({}, state, {
				isFetching: true,
				didInvalidate: false
			});
		case RECEIVE_POSTS:

			postsStore.addPostsToStore(action.posts);

			return Object.assign({}, state, {
				isFetching: false,
				didInvalidate: false,
				items: action.posts,
				lastUpdated: action.receivedAt
			});
		default:
			return state;
	}
}

export function postsByCacheKey(state = { }, action) {
	switch (action.type) {
		case INVALIDATE_SEARCH_QUERY:
		case RECEIVE_POSTS:
		case REQUEST_POSTS:
			return Object.assign({}, state, {
				[action.cacheKey]: posts(state[action.cacheKey], action)
			});
		default:
			return state;
	}
}

export function showArrows(state = { }, action) {
	switch (action.type) {
		case INVALIDATE_SEARCH_QUERY:
		case RECEIVE_POSTS:
		case REQUEST_POSTS: {
			const currentPosts = posts(state[action.cacheKey], action);
			return currentPosts && currentPosts.items.length > 0;
		}
		default:
			return state;
	}
}
