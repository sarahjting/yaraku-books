import { mount } from "@vue/test-utils";
import App from "../../resources/js/App.vue";

describe("App", () => {
    it("should mount without crashing", () => {
        const wrapper = mount(App);
    });
});
