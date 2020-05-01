import { shallowMount } from "@vue/test-utils";
import Vuex from "vuex";

import App from "../../../../resources/js/App.vue";

describe("Component", () => {
    let wrapper;
    let actions;

    beforeEach(() => {
        actions = {
            loadBooks: jest.fn()
        };
        wrapper = shallowMount(App, {
            store: new Vuex.Store({ actions })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
    });

    test("calls loadBooks", () => {
        expect(actions.loadBooks).toHaveBeenCalled();
    });
});
