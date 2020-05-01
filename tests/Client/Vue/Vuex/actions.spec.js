import actions from "../../../../resources/js/vuex/actions";

const mockBooks = [{ id: 1, title: "Foo Bar", author: { name: "Foo Bar" } }];
let mockApi;
jest.mock("../../../../resources/js/api/index", () => {
    mockApi = {
        books: jest.fn(async () => mockBooks),
        createBook: jest.fn(async () => mockBooks[0])
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
    test("loads books", async () => {
        const commit = jest.fn();
        const dispatch = jest.fn();

        await actions.createBook({ commit, dispatch });
        expect(mockApi.createBook).toHaveBeenCalled();
        expect(dispatch).toHaveBeenCalledWith("loadBooks");
    });
});
