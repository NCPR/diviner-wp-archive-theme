// ncaw_config for data coming from BE
const configDefault = {
	counties: [],
	donors: [],
	locations: [],
	institutions: [],
	decades: [],
	work_types: [],
	years: {
		min: 1850,
		max: 2017,
		default: [
			1890,
			1920
		]
	},
	order_by: [],
	tags: [],
	year_choices: [],  // contains all the years
	help_page: undefined,
	base_browse_url: 'TESTURL',
	permission_notice: ''
};

export const CONFIG = window.diviner_config || configDefault; // eslint-disable-line camelcase

