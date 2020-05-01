import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";

import CreateBookButton from "../../../../resources/js/components/Buttons/CreateBookButton.vue";

describe("CreateBookButton", () => {
    let wrapper;
    let actions;

    beforeEach(() => {
        actions = {
            createBook: jest.fn()
        };
        wrapper = mount(CreateBookButton, {
            store: new Vuex.Store({ actions })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
        expect(wrapper.vm.dialog).toBe(false);
    });

    test("opens modal when clicked", async () => {
        wrapper.find("button").trigger("click");
        await Vue.nextTick();
        expect(wrapper.vm.dialog).toBe(true);
    });

    test("updates form when filled", async () => {
        const expectedBook = {
            title: "book title",
            author: { name: "book author" }
        };
        wrapper.find("button").trigger("click");
        await Vue.nextTick();

        wrapper
            .findAll("input")
            .at(0)
            .setValue(expectedBook.title);
        wrapper
            .findAll("input")
            .at(1)
            .setValue(expectedBook.author.name);

        await Vue.nextTick();
        expect(wrapper.vm.book).toStrictEqual({
            title: "book title",
            author: { name: "book author" }
        });
    });

    test("submits form when filled", async () => {
        wrapper.vm.book = {
            title: "book title",
            author: { name: "book author" }
        };

        wrapper.find("button").trigger("click");
        await Vue.nextTick();

        const buttons = wrapper.findAll("button");
        buttons.at(buttons.length - 1).trigger("click");
        await Vue.nextTick();

        expect(wrapper.vm.dialog).toBe(false);
        expect(actions.createBook).toHaveBeenCalled();
    });
});
