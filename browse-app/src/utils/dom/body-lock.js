let scroll = 0;
let locked = false;
let scroller;

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
	scroll = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
	document.body.style.position = 'fixed';
	document.body.style.marginTop = `-${scroll}px`;
	locked = true;
	if (scroll === document.documentElement.scrollTop) {
		scroller = document.documentElement;
	} else if (scroll === document.body.scrollTop) {
		scroller = document.body;
	}
};

/**
 * @function unlock
 * @description Unlock the body and return it to its actual scroll position.
 */

const unlock = () => {
	if (!scroller) {
		return;
	}
	document.body.style.marginTop = '0px';
	document.body.style.position = 'static';
	scroller.scrollTop = scroll;
	locked = false;
	scroll = 0;
};

export { lock, unlock, isLocked };
