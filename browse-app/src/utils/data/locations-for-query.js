import _ from 'lodash';
import calculateDistance from './calculate-distance';
import { LOCATIONS } from '../../globals/wp';
import { SEARCH_TYPES } from '../../globals/config';

import * as units from './units';

const locations = _.cloneDeep(LOCATIONS);

const locationsByDistance = (lat, lng, country) => {
	const u = country === 'US' ? 'M' : 'K';
	for (let i = 0; i < locations.length; i++) {
		locations[i].distance = calculateDistance(lat, lng, locations[i].lat, locations[i].lng, u);
	}

	locations.sort((a, b) => a.distance - b.distance);

	return _.filter(locations, location => location.distance <= units.maxDistance && location.country.toLowerCase() === country.toLowerCase());
};

const locationsByState = (country, state) => _.filter(locations, location => location.country.toLowerCase() === country && location.state.toLowerCase() === state);
const locationsByCountry = country => _.filter(locations, location => location.country.toLowerCase() === country);

export const locationsForQuery = (lat = 0, lng = 0, country = 'US', state = 'all', type = 'normal') => {
	let results;
	switch (type) {
	case SEARCH_TYPES.distance:
		results = locationsByDistance(lat, lng, country);
		break;
	case SEARCH_TYPES.state:
		results = locationsByState(country, state);
		break;
	case SEARCH_TYPES.country:
		results = locationsByCountry(country);
		break;
	default:
		return results;
	}

	return results;
};

