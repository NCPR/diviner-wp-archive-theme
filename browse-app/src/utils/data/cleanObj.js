

const cleanObj = obj => {
	for (const propName in obj) {
		if (obj.hasOwnProperty(propName) &&
			(obj[propName] === null ||
				obj[propName] === undefined ||
				obj[propName] === '' ||
				obj[propName].length === 0)) {
			delete obj[propName];
		}
	}
};

export default cleanObj;
