
import _ from 'lodash';

// array of posts
const postStore = [];

export const addPostsToStore = (posts) => {
	posts.forEach((postToAdd) => {
		if (!_.some(postStore, { id: postToAdd.id })) {
			postStore.push(postToAdd);
		}
	});
};

export const getPostsById = (id) => _.find(postStore, { id });
