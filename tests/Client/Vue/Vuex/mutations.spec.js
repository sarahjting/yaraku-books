import mutations from "../../../../resources/js/vuex/mutations";

describe("Vuex Mutations", () => {
    test("can set isLoading", () => {
        const state = { isLoading: false };
        mutations.setLoading(state, true);
        expect(state.isLoading).toBe(true);
    });
    test("can set books", () => {
        const state = { books: [] };
        const updatedBooks = [{ title: "Foo" }, { title: "Bar" }];
        mutations.setBooks(state, updatedBooks);
        expect(state.books).toBe(updatedBooks);
    });
});
