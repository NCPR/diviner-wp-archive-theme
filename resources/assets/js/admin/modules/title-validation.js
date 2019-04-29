/**
 * @module
 * @description JavaScript to handle title validation on fields
 */
import delegate from 'delegate';
import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';


const el = {
	editFieldBody: document.querySelectorAll('body.post-edit--diviner_field')[0],
};

/**
 * @function validateTitle
 * @description Toggle menu on click
 */

const validateTitle = (e) => {
	const title = document.getElementById('title');
	if (!title) {
		return true;
	}
	const title_value = title.value.trim();
	if(title_value === '' || title_value.length === 0){
		alert('Please insert title');
		const spinner = document.querySelectorAll('.spinner')[0];
		if (spinner) {
			spinner.style.visibility = 'hidden';
		}
		title.focus();
		e.preventDefault();
		return false;
	}

};


/**
 * @function bindEvents
 * @description Bind the events for this module.
 */

const bindEvents = () => {
	delegate(el.editFieldBody, '#publish', 'click', validateTitle);
	delegate(el.editFieldBody, '#save-post', 'click', validateTitle);
};

/**
 * @function init
 * @description Kick off this modules functions
 */

const init = () => {
	if (el.editFieldBody) {
		bindEvents();

		console.info('Diviner: Initialized title validation script.');
	}
};

export default init;
