export default {
    setLoading(state, isLoading) {
        state.isLoading = isLoading;
    },
    setBooks(state, books) {
        state.books = books;
    },
    setFilterBy(state, filterBy) {
        state.filterBy = filterBy;
    },
    setFilter(state, filter) {
        state.filter = filter;
    }
};
