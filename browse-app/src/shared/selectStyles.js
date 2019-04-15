
export const selectStyles = {
	indicatorsContainer: base => ({
		...base,
		width: '38px',
		height: '38px',
	}),
	indicatorSeparator: () => ({
		display: 'none',
	}),
	option: base => ({
		...base,
		borderRadius: 0,
		height: '40px',
	}),
	control: base => ({
		...base,
		borderRadius: 0,
		borderWidth: 1,
		height: '40px',
	}),
};

export function selectTheme(theme) {
	return {
		...theme,
		borderRadius: 0,
		colors: {
			...theme.colors,
			text: 'orangered',
			primary25: 'hotpink',
			primary: 'black',
		},
	};
};
