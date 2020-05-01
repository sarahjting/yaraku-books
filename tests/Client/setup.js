import Vue from "vue";
import vuetify from "vuetify";
import Vuex from "vuex";
import "regenerator-runtime/runtime.js";

require("dotenv").config();

Vue.use(vuetify);
Vue.use(Vuex);

// https://github.com/vuetifyjs/vuetify/issues/3456#issuecomment-408424406
// required to stop vuetify from complaining about not being able to find [data-app]
const el = document.createElement("div");
el.setAttribute("data-app", true);
document.body.appendChild(el);
