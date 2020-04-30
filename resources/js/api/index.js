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
    createBook: function(bookInput) {
        return callGraphQL(
            `mutation($book: BookInput!) {
                createBook(book: $book){ id title author{id name} }
            }`,
            { book: bookInput }
        ).then(data => (data.errors ? data : data.data.createBook));
    },
    deleteBook: function(bookId) {
        return callGraphQL(
            `mutation($id: Int!) {
                deleteBook(id: $id)
            }`,
            { id: bookId }
        ).then(data => (data.errors ? data : data.data.deleteBook));
    },
    updateAuthor: function(authorId, authorInput) {
        return callGraphQL(
            `mutation($id: Int!, $author: AuthorInput!) {
                updateAuthor(id: $id, author: $author){ id name }
            }`,
            { id: authorId, author: authorInput }
        ).then(data => (data.errors ? data : data.data.updateAuthor));
    }
};

export default api;
