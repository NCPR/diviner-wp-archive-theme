export default {
	indicatorsContainer: base => ({
		...base,
		width: '48px',
		height: '48px',
		background: '#e3a161',
	}),
	indicatorSeparator: () => ({
		display: 'none',
	}),
	option: base => ({
		...base,
		borderRadius: 0,
		height: '50px',
	}),
	control: base => ({
		...base,
		width: 300,
		borderColor: '#e3a161',
		borderRadius: 0,
		height: '50px',
	}),
};
