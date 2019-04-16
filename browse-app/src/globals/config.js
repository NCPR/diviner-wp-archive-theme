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
	browse_page_localization: {
		popup_view_details: '',
		popup_permission_statement: '',
		popup_previous: '',
		popup_next: '',
		grid_default: '',
		grid_loading: '',
		grid_no_results: '',
		paginate_previous: '',
		paginate_next: '',
		search_header: '',
		search_placeholder: '',
		search_cta: '',
		facets_header: '',
		facets_sort_label: '',
		facets_sort_clear: '',
		facets_reset: '',
	},
};

export const CONFIG = window.diviner_config || configDefault; // eslint-disable-line camelcase
