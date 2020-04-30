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
    }
};

export default api;
