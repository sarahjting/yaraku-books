import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import Vuetify from "vuetify";

import DataTable from "../../../../resources/js/components/DataTable.vue";

describe("CreateBookButton", () => {
    let wrapper;
    let state;

    beforeEach(() => {
        state = {
            isLoading: false,
            filter: "",
            filterBy: "Author",
            books: [
                {
                    title: "Title 1",
                    author: { givenName: "Foo", familyName: "Bar" }
                },
                {
                    title: "Title 2",
                    author: { givenName: "Foo", familyName: "Bar" }
                },
                {
                    title: "Title 3",
                    author: { givenName: "Hello", familyName: "World" }
                }
            ]
        };
        wrapper = mount(DataTable, {
            vuetify: new Vuetify({}),
            store: new Vuex.Store({ state })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
    });

    test("shows books", async () => {
        expect(wrapper.findAll("tbody tr").length).toBe(state.books.length);
    });

    test("filters books by author", async () => {
        state.filter = "Hello";
        await Vue.nextTick();

        expect(wrapper.vm.tableBody.length).toBe(1);
        expect(wrapper.vm.tableBody[0]).toStrictEqual(state.books[2]);
    });

    test("filters books by title", async () => {
        state.filterBy = "Title";
        state.filter = "Title 3";
        await Vue.nextTick();

        expect(wrapper.vm.tableBody.length).toBe(1);
        expect(wrapper.vm.tableBody[0]).toStrictEqual(state.books[2]);
    });

    test("filters books by author on click", async () => {
        wrapper.find(".mdi-magnify").trigger("click");
        expect(state.filterBy).toBe("Author");
        expect(state.filter).toContain(state.books[0].author.givenName);
    });
});
