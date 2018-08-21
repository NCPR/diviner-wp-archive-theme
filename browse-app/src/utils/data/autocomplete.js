import _ from 'lodash';
import { SEARCH_TYPES } from '../../globals/config';

const hasAddressComponents = (data = {}) => data.gmaps && data.gmaps.address_components;
const hasCountry = data => hasAddressComponents(data) && _.findIndex(data.gmaps.address_components, (o) => o.types[0] === 'country') !== -1;
const countrySearch = data => hasCountry(data) && data.gmaps.address_components.length === 1;
const stateSearch = data => hasAddressComponents(data) && data.gmaps.address_components.length === 2 && data.gmaps.address_components[1].short_name === 'US';
const provinceSearch = data => hasAddressComponents(data) && data.gmaps.address_components.length === 2 && data.gmaps.address_components[1].short_name === 'CA';

export const type = (data) => {
	let searchType;
	if (countrySearch(data)) {
		searchType = SEARCH_TYPES.country;
	} else if (stateSearch(data)) {
		searchType = SEARCH_TYPES.state;
	} else if (provinceSearch(data)) {
		searchType = SEARCH_TYPES.state;
	} else {
		searchType = SEARCH_TYPES.distance;
	}

	return searchType;
};
