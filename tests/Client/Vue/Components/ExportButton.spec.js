import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";

import ExportButton from "../../../../resources/js/components/Buttons/ExportButton.vue";

describe("ExportButton", () => {
    let wrapper;
    let actions;

    beforeEach(() => {
        wrapper = mount(ExportButton, {
            vuetify: new Vuetify({})
        });
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
        expect(wrapper.vm.dialog).toBe(false);
        expect(wrapper.vm.format).toBe("XML");
        expect(wrapper.vm.fields).toStrictEqual({
            title: true,
            "author.name": true
        });
        expect(wrapper.vm.downloadLink).toBe(
            "/export/books?format=XML&fields=title,author.name"
        );
    });

    test("opens modal when clicked", async () => {
        wrapper.find("button").trigger("click");
        await Vue.nextTick();
        expect(wrapper.vm.dialog).toBe(true);
    });

    test("updates link when filled", async () => {
        wrapper.find("button").trigger("click");
        await Vue.nextTick();

        wrapper.find(".v-select__slot input").setValue("CSV");
        wrapper.find("input[type='checkbox']").trigger("click");
        await Vue.nextTick();

        expect(wrapper.vm.format).toBe("CSV");
        expect(wrapper.vm.fields).toStrictEqual({
            title: false,
            "author.name": true
        });
        expect(wrapper.vm.downloadLink).toBe(
            "/export/books?format=CSV&fields=author.name"
        );
        expect(wrapper.find("a.green").attributes("href")).toBe(
            wrapper.vm.downloadLink
        );
    });
});
