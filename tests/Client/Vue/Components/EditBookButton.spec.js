import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import Vuetify from "vuetify";

import EditBookButton from "../../../../resources/js/components/Buttons/EditBookButton.vue";

describe("EditBookButton", () => {
    let wrapper;
    let actions;
    let book;

    beforeEach(() => {
        book = {
            id: 1,
            title: "Book Title",
            author: {
                givenName: "Foo",
                familyName: "Bar"
            }
        };
        actions = {
            updateBook: jest.fn()
        };
        wrapper = mount(EditBookButton, {
            propsData: { book },
            vuetify: new Vuetify({}),
            store: new Vuex.Store({ actions })
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
        expect(wrapper.vm.dialog).toBe(false);
        expect(wrapper.vm.formBook).toStrictEqual({
            title: "Book Title",
            author: {
                name: "Foo Bar"
            }
        });
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
        expect(wrapper.vm.formBook).toStrictEqual({
            title: "book title",
            author: { name: "book author" }
        });
    });

    test("submits form when filled", async () => {
        wrapper.vm.formBook = {
            title: "book title",
            author: { name: "book author" }
        };

        wrapper.find("button").trigger("click");
        await Vue.nextTick();

        const buttons = wrapper.findAll("button");
        buttons.at(buttons.length - 1).trigger("click");
        await Vue.nextTick();

        expect(wrapper.vm.dialog).toBe(false);
        expect(actions.updateBook).toHaveBeenCalled();
    });
});
