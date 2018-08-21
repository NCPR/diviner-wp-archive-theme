import { API_CONFIG, I18N } from '../../globals/wp';

const radius = parseInt(API_CONFIG.radius_search, 10);

export const imperial = API_CONFIG.units === 'imperial';
export const maxDistance = imperial ? radius : radius * 1.609344;
export const translated = imperial ? I18N.miles : I18N.km;
