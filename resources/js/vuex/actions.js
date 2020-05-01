import apiModule from "../api/index";
const api = apiModule();

export default {
    loadBooks({ commit }) {
        commit("setLoading", true);
        return api.books().then(books => {
            commit("setBooks", books);
            commit("setLoading", false);
            return books;
        });
    },

    createBook({ commit, dispatch }, book) {
        commit("setLoading", true);
        api.createBook(book).then(book => {
            dispatch("loadBooks");
        });
    }
};
