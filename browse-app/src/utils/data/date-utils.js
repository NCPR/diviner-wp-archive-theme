

export const getDecade = (date) => {
	date = date instanceof Date ? date : new Date(date);

	let fullYear = date.getFullYear().toString();
	let decade = fullYear.substring(0, 3);

	if (Number.isNaN(fullYear) || !decade || (fullYear.length < 4)) {
		throw new Error('Date must be valid and have a 4-digit year attribute');
	}

	return `${decade}0s`
};

export const getCentury = (date) => {
	date = date instanceof Date ? date : new Date(date);

	let fullYear = date.getFullYear().toString();
	let century = fullYear.substring(0, 2);
	console.log('fullYear', fullYear)

	if (Number.isNaN(fullYear) || !century || (fullYear.length < 4)) {
		throw new Error('Date must be valid and have a 4-digit year attribute');
	}

	return `${century}00s`
};