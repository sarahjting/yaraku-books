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
    test("can set filter", () => {
        const state = { filter: "Author" };
        const updatedFilter = "Book";
        mutations.setFilter(state, updatedFilter);
        expect(state.filter).toBe(updatedFilter);
    });
    test("can set filterBy", () => {
        const state = { filterBy: "" };
        const updatedFilterBy = "Foo";
        mutations.setFilterBy(state, updatedFilterBy);
        expect(state.filterBy).toBe(updatedFilterBy);
    });
});
