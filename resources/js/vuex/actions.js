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
    }
};
