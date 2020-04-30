import axios from "axios";

import httpAdapter from "axios/lib/adapters/http";
import https from "https";

import api from "../../../resources/js/api/index";

describe("API", () => {
    // graphql is tested by PHPUnit, so i only want to test that the endpoints are returning 200 and no error messages
    it("should get a list of books from GraphQL", async () => {
        let books = await api.books();
        expect(Array.isArray(books)).toBeTruthy();
    });
});
