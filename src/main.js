import Vue from "vue";
import App from "./App.vue";
import Router from "./routes.js";
import VueResource from "vue-resource";
import VeeValidate from "vee-validate";
import VueRangedatePicker from "vue-rangedate-picker";
import Auth from "./packages/auth/Auth.js";
import Global from "./packages/local/Global.js";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import VueSidebarMenu from "vue-sidebar-menu";
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import vueCountryRegionSelect from "vue-country-region-select";
// import { jsPDF } from "jspdf";
import JsonExcel from "vue-json-excel";

import VueHtmlToPaper from "vue-html-to-paper";
//import excel from "vue-excel-export";

//import DateRangePicker from "vue2-daterange-picker";

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
        "https://unpkg.com/kidlat-css/css/kidlat.css"
    ]
};
// const doc = new jsPDF();
// doc.text("Hello world!", 10, 10);
// doc.save("a4.pdf");

Vue.use(VueHtmlToPaper, options);
Vue.use(vueCountryRegionSelect);
Vue.use(VueSidebarMenu);
Vue.use(VueRangedatePicker);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueResource);
Vue.component("downloadExcel", JsonExcel);
Vue.use(Auth);
Vue.use(Global);
Vue.use(VeeValidate, {
    fieldsBagName: "veeFields"
});

function getEnvVal(str) {
    const indexOfSpace = str.indexOf("=");
    if (indexOfSpace === -1) {
        return "";
    }
    return str.substring(indexOfSpace + 1);
}
async function fetchenv() {
    await fetch("settings.env")
        .then(response => response.text())
        .then(function(text) {
            var data = text.split("\n");
            data.forEach(item => {
                const varr = item.split("=")[0];
                if (varr == "root") Vue.http.options.root = getEnvVal(item);
                if (varr == "img_path") Vue.prototype.$img_path = getEnvVal(item);
                if (varr == "sys_path") Vue.prototype.$sys_path = getEnvVal(item);
                if (varr == "attachment_path")
                    Vue.prototype.$attachment_path = getEnvVal(item);
                if (varr == "sms_switch") {
                    Vue.prototype.$sms_switch = getEnvVal(item);
                }
                if (varr == "email_switch") {
                    Vue.prototype.$email_switch = getEnvVal(item);
                }
            });
        });
}

async function loadKeycloak() {
    await fetchenv();
    Vue.http.headers.common["Authorization"] = "Bearer " + Vue.auth.getToken();

    Router.beforeEach((to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({
                    path: "/home"
                });
            } else next();
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({
                    path: "/login"
                });
            } else next();
        } else next();
    });

    new Vue({
        el: "#app",
        render: h => h(App),
        router: Router
    });
}
loadKeycloak();

// var protocol = window.location.protocol;

// if (window.location.host == "localhost:8080") {
//   Vue.http.options.root = "http://localhost:8000";
//   Vue.prototype.$img_path = "http://localhost:8000/attachments/";
//   Vue.prototype.$back_url = "http://localhost:8000/back/";
// } else {
//   Vue.http.options.root = protocol + "//" + window.location.host + "/back/";
//   Vue.prototype.$img_path =
//     protocol + "//" + window.location.host + "/back/public/attachments/";
//   Vue.prototype.$attachment_path =
//     protocol + "//" + window.location.host + "/back/public/attachments/";
// }
//http://localhost:8082/Membership/