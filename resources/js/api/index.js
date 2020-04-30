import axios from "axios";
import httpAdapter from "axios/lib/adapters/http";
import https from "https";

const axiosInstance = axios.create({
    adapter: httpAdapter,
    httpsAgent: new https.Agent({
        rejectUnauthorized: process.env.APP_ENV === "production"
    })
});

function callGraphQL(query, variables = []) {
    return axiosInstance
        .post(process.env.APP_URL + "graphql", {
            query,
            variables
        })
        .then(data => data.data);
}

const api = {
    books: function() {
        return callGraphQL(`query{
            books{ id title author{ id name } }
        }`).then(data => (data.errors ? data : data.data.books));
    },

    createBook: function(book) {
        return callGraphQL(
            `mutation($book: BookInput!) {
                createBook(book: $book){ id title author{id name} }
            }`,
            { book }
        ).then(data => (data.errors ? data : data.data.createBook));
    },

    deleteBook: function(id) {
        return callGraphQL(
            `mutation($id: Int!) {
                deleteBook(id: $id)
            }`,
            { id }
        ).then(data => (data.errors ? data : data.data.deleteBook));
    },

    updateBook: function(id, book) {
        return callGraphQL(
            `mutation($id: Int!, $book: BookInput!) {
                updateBook(id: $id, book: $book){ id title author{id name} }
            }`,
            { id, book }
        ).then(data => (data.errors ? data : data.data.updateBook));
    }
};

export default api;
