/**
 * example usage:
 *
var items = sample.items;
for ( var i = 0; i < items.length; i++) {
	items[i]["distance"] = calculateDistance( 40.7305991, -73.9865812, items[i]["site"]["latLng"][0], items[i]["site"]["latLng"][1]);
}

items.sort(function(a, b) {
	return a.distance - b.distance;
});
 *
 * @param lat1
 * @param lon1
 * @param lat2
 * @param lon2
 * @param unit
 * @returns {number}
 */

export default function calculateDistance(lat1, lon1, lat2, lon2, unit) {
	const radlat1 = Math.PI * lat1 / 180;
	const radlat2 = Math.PI * lat2 / 180;
	const theta = lon1 - lon2;
	const radtheta = Math.PI * theta / 180;
	let dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
	dist = Math.acos(dist);
	dist = dist * 180 / Math.PI;
	dist = dist * 60 * 1.1515;
	if (unit === 'K') {
		dist = dist * 1.609344;
	}

	if (unit === 'N') {
		dist = dist * 0.8684;
	}

	return dist.toFixed(2);
}
