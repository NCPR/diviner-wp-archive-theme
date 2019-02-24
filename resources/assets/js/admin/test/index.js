import React from 'react';
import ReactDOM from 'react-dom';

const title = 'My Minimal React Webpack Babel Setup';

const test = () => {
	const elem = document.createElement('div');
	elem.id = "test-item";
	document.body.appendChild(elem);
	ReactDOM.render(
		<div>{title}</div>,
		document.getElementById('test-item')
	);
};

export default test;
