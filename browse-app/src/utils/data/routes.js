import _ from 'lodash';

import { SEARCH_TYPES } from '../../globals/config';
import { BASE_PATH } from '../../globals/wp';
import * as autocomplete from './autocomplete';

export const locationRoute = (data = {}) => {
	if (!data.gmaps) {
		return BASE_PATH;
	}
	const ac = data.gmaps.address_components;
	const type = autocomplete.type(data);
	const country = ac[_.findIndex(ac, o => o.types[0] === 'country')].short_name.toLowerCase();
	const state = type === SEARCH_TYPES.state ? ac[_.findIndex(ac, o => o.types[0] === 'administrative_area_level_1')].short_name.toLowerCase() : 'all';
	return `${BASE_PATH}location/${data.location.lat}/${data.location.lng}/${country}/${state}/${type}/${data.label}/`;
};

export const userLocationRoute = (data = {}) => {
	const a = data.results[0] || {};
	const l = a.geometry && a.geometry.location || {};
	const ac = a.address_components || [];
	const country = ac[_.findIndex(ac, o => o.types[0] === 'country')].short_name.toLowerCase();
	const address = encodeURIComponent(a.formatted_address);
	let url = window.location.href;
	if (country) {
		url = `${BASE_PATH}location/${l.lat}/${l.lng}/${country}/all/distance/${address}/`;
	}
	return url;
};
