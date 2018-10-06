// This is a util, it is re-usable and
// it can be invoked as needed by other
// scripts in your app. By itself it
// does nothing :)
export default function stateToParameters(state) {
	const stringable = {
		base: 'ALL',
		filters: {},
		page: state.page
	};
	if (state.decadeFilter) {
		stringable.filters.decade = state.decadeFilter;
	}
	if (state.countyFilter) {
		stringable.filters.county = state.countyFilter;
	}
	if (state.workTypeFilter) {
		stringable.filters.work = state.workTypeFilter;
	}
	if (state.locationFilter) {
		stringable.filters.location = state.locationFilter;
	}
	if (state.tagsFilter) {
		stringable.filters.tags = state.tagsFilter;
	}
	if (state.queryString) {
		stringable.filters.query = state.queryString;
	}
	if (state.dateFilter) {
		stringable.filters.date = state.dateFilter;
	}
	if (state.institutionFilter) {
		stringable.filters.institution = state.institutionFilter;
	}
	if (state.orderBy) {
		stringable.orderBy = state.orderBy;
	}
	// state.page = state.page;
	return JSON.stringify(stringable);
}
