import _ from 'lodash';

/*
Comes in via the Carbon fields complex field (repeater)

[
	{
		"_type":"_",
		"div_field_select_options_value":"Red"
		"div_field_select_options_label":"Red"
	},
	{
		"_type":"_",
		"div_field_select_options_value":"Blond"
		"div_field_select_options_label":"Red"
	}
]
 */

export const carbonFieldSelectToSelectOptions = (posts) => {
	const options = [];
	if (posts) {
		_.each(posts, (post) => {
			options.push({
				value: post.div_field_select_options_value,
				label: post.div_field_select_options_label
			});
		});
	}
	return options;
};
