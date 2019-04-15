/**
 * @module
 * @description Some handy test for common issues.
 */

const isIE = /* @cc_on!@ */false || document.documentMode;

const browserTests = () => ({
	android: /Android/i.test(window.navigator.userAgent) && /Mobile/i.test(window.navigator.userAgent),
	chrome: !!window.chrome,
	firefox: typeof InstallTrigger !== 'undefined',
	ie: isIE,
	edge: !isIE && !!window.StyleMedia,
	ios: !!navigator.userAgent.match(/(iPod|iPhone|iPad)/i),
	iosMobile: !!navigator.userAgent.match(/(iPod|iPhone)/i),
	safari: Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0,
	opera: !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
	os: navigator.platform,
});

export { browserTests };
