import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import Vuetify from "vuetify";

import SearchBar from "../../../../resources/js/components/TopBar/SearchBar.vue";

describe("SearchBar", () => {
    let wrapper;
    let state;

    beforeEach(() => {
        state = {
            filter: "",
            filterBy: ""
        };
        wrapper = mount(SearchBar, {
            vuetify: new Vuetify({}),
            store: new Vuex.Store({ state })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
    });

    test("updates form when filled", async () => {
        wrapper
            .findAll("input")
            .at(0)
            .setValue("Foo");
        wrapper
            .findAll("input")
            .at(2)
            .setValue("Bar");

        await Vue.nextTick();
        expect(state.filterBy).toEqual("Foo");
        expect(state.filter).toEqual("Bar");
    });
});
