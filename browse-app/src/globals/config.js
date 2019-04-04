// ncaw_config for data coming from BE
const configDefault = {
	browse_page_title: '',
	browse_page_content: '',
	base_browse_url: '',
	order_by: [],
	tags: [],
	taxonomies: [],
	fields: [],
	cpt_posts: [],
	settings: {
		display_popup: false,
		help_page_link: '',
		permission_notice: ''
	},
};

export const CONFIG = window.diviner_config || configDefault; // eslint-disable-line camelcase

