
const android = /(android)/i.test(navigator.userAgent);
const chrome = !!window.chrome;
const firefox = typeof InstallTrigger !== 'undefined';
const ie = /* @cc_on!@ */false || document.documentMode;
const edge = !ie && !!window.StyleMedia;
const ios = !!navigator.userAgent.match(/(iPod|iPhone|iPad)/i);
const iosMobile = !!navigator.userAgent.match(/(iPod|iPhone)/i);
const opera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
const safari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0 || !chrome && !opera && window.webkitAudioContext !== 'undefined'; // eslint-disable-line
const os = navigator.platform;

const browserTests = () => ({
	android,
	chrome,
	edge,
	firefox,
	ie,
	ios,
	iosMobile,
	opera,
	safari,
	os,
});

export { browserTests };
