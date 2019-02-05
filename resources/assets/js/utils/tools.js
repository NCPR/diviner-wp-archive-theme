/**
 * @module
 * @description Some vanilla js cross browser utils
 */


/**
 * Convert a nodelist into a standard array.
 *
 * @param {Element|NodeList} elements to convert
 * @returns {Array} Of converted elements
 */

export const convertElementsToArray = (elements = []) => {
	const converted = [];
	let i = elements.length;
	for (i; i--; converted.unshift(elements[i])); // eslint-disable-line

	return converted;
};

/**
 * Gets the closest ancestor that matches a selector string
 *
 * @param el
 * @param selector
 * @returns {*}
 */

export const closestAncestor = (el, selector) => {
	let matchesFn;
	let parent;

	['matches', 'webkitMatchesSelector', 'mozMatchesSelector', 'msMatchesSelector', 'oMatchesSelector'].some((fn) => {
		if (typeof document.body[fn] === 'function') {
			matchesFn = fn;
			return true;
		}
		return false;
	});

	// loop upward
	while (el) {
		parent = el.parentElement;
		if (parent && parent[matchesFn](selector)) {
			return parent;
		}
		el = parent;
	}

	return null;
};

