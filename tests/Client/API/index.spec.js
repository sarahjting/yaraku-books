import apiModule from "../../../resources/js/api/index";
import axios from "axios";
import httpAdapter from "axios/lib/adapters/http";
import https from "https";

const api = apiModule(
    axios.create({
        adapter: httpAdapter,
        httpsAgent: new https.Agent({
            rejectUnauthorized: false
        })
    }),
    process.env.APP_URL
);

describe("GraphQL API", () => {
    let book;

    // graphql is tested by PHPUnit, so i only want to test that the endpoints are returning 200 and no error messages
    it("should get a list of books", async () => {
        const books = await api.books();
        expect(Array.isArray(books)).toBeTruthy();
    });

    describe("create, update, delete a book", () => {
        it("should create a book", async () => {
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
            expect(book.author.givenName).toBe("Foodinand");
        });

        it("should update a book", async () => {
            const rawBook = {
                title: "Hello World",
                author: { name: "Foobert Barney" }
            };
            const updatedBook = await api.updateBook(book.id, rawBook);

            expect(typeof updatedBook).toBe("object");
            expect(updatedBook.errors).not.toBeDefined();

            expect(updatedBook.id).toBe(book.id);
            expect(updatedBook.title).toBe(rawBook.title);
            expect(updatedBook.author.id).toBeDefined();
            expect(updatedBook.author.givenName).toBe("Foobert");
        });

        it("should delete a book", async () => {
            let result = await api.deleteBook(book.id);
            expect(result).toBe(true);
        });
    });
});
