const getParams = query => {
	if (!query) {
		return { };
	}
	const obj = {};
	return (/^[?#]/.test(query) ? query.slice(1) : query)
		.split('&')
		.reduce((params, param) => {
			const [key, value] = param.split('=');
			obj[key] = value ? decodeURIComponent(value.replace(/\+/g, ' ')) : '';
			return obj;
		}, { });
};

export default getParams;
