import actions from "../../../../resources/js/vuex/actions";

const mockBooks = [{ id: 1, title: "Foo Bar", author: { name: "Foo Bar" } }];
let mockApi;
jest.mock("../../../../resources/js/api/index", () => {
    mockApi = {
        books: jest.fn(async () => mockBooks),
        createBook: jest.fn(async () => mockBooks[0]),
        deleteBook: jest.fn(async () => false),
        updateBook: jest.fn(async () => mockBooks[0])
    };
    return () => mockApi;
});

describe("Vuex Actions", () => {
    beforeEach(() => {
        Object.keys(mockApi).forEach(x => {
            mockApi[x].mockClear();
        });
    });
    test("loads books", async () => {
        const commit = jest.fn();

        await actions.loadBooks({ commit });

        expect(mockApi.books).toHaveBeenCalled();
        expect(commit).toHaveBeenCalledWith("setBooks", mockBooks);
        expect(commit).toHaveBeenCalledWith("setLoading", false);
    });
    test("creates books", async () => {
        const commit = jest.fn();
        const dispatch = jest.fn();

        await actions.createBook({ commit, dispatch }, mockBooks[0]);
        expect(mockApi.createBook).toHaveBeenCalled();
        expect(dispatch).toHaveBeenCalledWith("loadBooks");
    });
    test("deletes books", async () => {
        const commit = jest.fn();
        const dispatch = jest.fn();

        await actions.deleteBook({ commit, dispatch });
        expect(mockApi.deleteBook).toHaveBeenCalled();
        expect(dispatch).toHaveBeenCalledWith("loadBooks");
    });
    test("updates books", async () => {
        const commit = jest.fn();
        const dispatch = jest.fn();

        await actions.updateBook(
            { commit, dispatch },
            {
                id: mockBooks[0].id,
                book: mockBooks[0]
            }
        );
        expect(mockApi.updateBook).toHaveBeenCalled();
        expect(dispatch).toHaveBeenCalledWith("loadBooks");
    });
});
