import actions from "../../../../resources/js/vuex/actions";

const mockBooks = [{ id: 1, title: "Foo Bar", author: { name: "Foo Bar" } }];
jest.mock("../../../../resources/js/api/index", () => {
    return () => ({ books: async () => mockBooks });
});

describe("Vuex Actions", () => {
    test("loads books", async () => {
        const commit = jest.fn();

        await actions.loadBooks({ commit });
        expect(commit).toHaveBeenCalledWith("setBooks", mockBooks);
        expect(commit).toHaveBeenCalledWith("setLoading", false);
    });
});
