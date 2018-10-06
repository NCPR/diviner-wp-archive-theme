import _ from 'lodash';

export const postsToSelectOptions = (posts) => {
	const options = [];
	if (posts) {
		_.each(posts, (post) => {
			options.push({
				value: post.ID,
				label: post.post_title
			});
		});
	}
	return options;
};
