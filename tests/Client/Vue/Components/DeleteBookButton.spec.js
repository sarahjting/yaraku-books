import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import Vuetify from "vuetify";

import DeleteBookButton from "../../../../resources/js/components/Buttons/DeleteBookButton.vue";

describe("DeleteBookButton", () => {
    let wrapper;
    let actions;

    beforeEach(() => {
        actions = {
            deleteBook: jest.fn()
        };
        wrapper = mount(DeleteBookButton, {
            propsData: {
                book: {
                    id: 1
                }
            },
            vuetify: new Vuetify({}),
            store: new Vuex.Store({ actions })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
        expect(wrapper.vm.dialog).toBe(false);
    });

    test("opens modal when clicked", async () => {
        wrapper.find("button.mdi-delete").trigger("click");
        await Vue.nextTick();
        expect(wrapper.vm.dialog).toBe(true);
    });

    test("submits form when confirmed", async () => {
        wrapper.find("button.mdi-delete").trigger("click");
        await Vue.nextTick();

        wrapper.find("button.red").trigger("click");
        await Vue.nextTick();

        expect(actions.deleteBook).toHaveBeenCalledWith(expect.anything(), 1);
        expect(wrapper.vm.dialog).toBe(false);
    });
});
