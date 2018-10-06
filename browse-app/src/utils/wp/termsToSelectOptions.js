import _ from 'lodash';

export const termsToSelectOptions = (terms) => {
	const options = [];
	if (terms) {
		_.each(terms, (term) => {
			options.push({
				value: term.term_id,
				label: term.name
			});
		});
	}
	return options;
};
