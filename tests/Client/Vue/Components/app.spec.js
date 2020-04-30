import { shallowMount } from "@vue/test-utils";
import App from "../../../../resources/js/App.vue";

describe("Component", () => {
    let wrapper;

    beforeEach(() => {
        wrapper = shallowMount(App);
    });

    test("is a Vue instance", () => {
        expect(wrapper.isVueInstance()).toBe(true);
    });
});
