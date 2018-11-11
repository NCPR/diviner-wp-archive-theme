import _ from 'lodash';

import { FIELD_PROP_FIELD_ID } from '../../config/settings';
import { CONFIG } from '../../globals/config';

export const getFieldTypeFromId = (fieldId) => {
	return _.find(CONFIG.fields, (field) => {
		return field[FIELD_PROP_FIELD_ID] === fieldId;
	})
};

export const getTaxonomyItemsFromTermIds = (taxId, ids) => {
	console.log('getTaxonomyItemsFromTermIds', CONFIG.taxonomies);
	const items = [];
	_.forEach(ids, (id) => {
		const item = _.find(CONFIG.taxonomies[taxId], { 'term_id': id });
		if (item) {
			items.push(item);
		}
	});
	return items;
};

export const getCPTsFromIds = (cptId, ids) => {
	const items = [];
	_.forEach(ids, (id) => {
		const item = _.find(CONFIG.cpt_posts[cptId], { 'ID': id });
		if (item) {
			items.push(item);
		}
	});
	return items;
};
