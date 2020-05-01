import "./bootstrap";
import Vue from "vue";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import store from "./vuex/store";

new Vue({
    render: (h) => h(App),
    vuetify,
    store,
}).$mount("#app");
