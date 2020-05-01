import axios from "axios";

export const apiModule = (axiosInstance, baseUrl = "/") => {
    if (axiosInstance === undefined) {
        axiosInstance = axios;
    }

    function getBookQuerySignature() {
        return "id title author {id givenName familyName}";
    }

    function callGraphQL(query, variables = []) {
        return axiosInstance
            .post(`${baseUrl}graphql`, {
                query,
                variables
            })
            .then(data => data.data);
    }

    return {
        books: function() {
            return callGraphQL(`query{
                books{ ${getBookQuerySignature()} }
            }`).then(data => (data.errors ? data : data.data.books));
        },

        createBook: function(book) {
            return callGraphQL(
                `mutation($book: BookInput!) {
                    createBook(book: $book){ ${getBookQuerySignature()} }
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
                    updateBook(id: $id, book: $book){ ${getBookQuerySignature()} }
                }`,
                { id, book }
            ).then(data => (data.errors ? data : data.data.updateBook));
        }
    };
};

export default apiModule;
