let scroll = 0;
let locked = false;
let scrollObj = undefined;

/**
 * @function isLocked
 * @description Returns state
 */

const isLocked = () => locked;

/**
 * @function lock
 * @description Lock the body at a particular position and prevent scroll,
 * use margin to simulate original scroll position.
 */

const lock = () => {
	if (document.documentElement.scrollTop > document.body.scrollTop) {
		scrollObj = document.documentElement;
	} else {
		scrollObj = document.body;
	}
	scroll = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
	document.body.style.position = 'fixed';
	document.body.style.marginTop = `-${scroll}px`;
	locked = true;
};

/**
 * @function unlock
 * @description Unlock the body and return it to its actual scroll position.
 */

const unlock = () => {
	if (!scrollObj) {
		return;
	}
	document.body.style.marginTop = '0px';
	document.body.style.position = 'static';
	scrollObj.scrollTop = scroll;
	locked = false;
	scroll = 0;
};

export { lock, unlock, isLocked };
