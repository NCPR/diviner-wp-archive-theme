
import cleanObj from './cleanObj';

export default (obj) => {

	obj = cleanObj(obj);

	return Object.keys(obj).map((k) =>
	{
		if (!obj[k]) {
			return '';
		}
		return `${k}=${encodeURIComponent(obj[k])}`;
	}).join('&');
}
