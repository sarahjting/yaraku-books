import api from "../../../resources/js/api/index";

describe("API", () => {
    // graphql is tested by PHPUnit, so i only want to test that the endpoints are returning 200 and no error messages
    it("should get a list of books from GraphQL", async () => {
        const books = await api.books();
        expect(Array.isArray(books)).toBeTruthy();
    });

    describe("create and delete a book", () => {
        let book;

        it("should create a book via GraphQL", async () => {
            const rawBook = {
                title: "Foo Bar",
                author: { name: "Foodinand Bartholomew" }
            };
            book = await api.createBook(rawBook);

            expect(typeof book).toBe("object");
            expect(book.errors).not.toBeDefined();

            expect(book.id).toBeDefined();
            expect(book.title).toBe(rawBook.title);
            expect(book.author.id).toBeDefined();
            expect(book.author.name).toBe(rawBook.author.name);
        });

        it("should delete a book via GraphQL", async () => {
            let result = await api.deleteBook(book.id);
            expect(result).toBe(true);
        });
    });
});
