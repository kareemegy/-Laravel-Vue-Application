/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueRouter from "vue-router";
import { Form, HasError, AlertError } from "vform";
import Moment from "moment";
import VueProgressBar from "vue-progressbar";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import Gate from "../js/Gate";
require("./bootstrap");
window.Vue = require("vue");
window.Form = Form;
Vue.prototype.$gate = new Gate(window.user);

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.use(VueRouter);
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "5px"
});

Vue.use(VueSweetalert2);

let routes = [
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default
    },
    {
        path: "/developer",
        component: require("./components/Developer.vue").default
    },
    {
        path: "/profile",
        component: require("./components/Profile.vue").default
    },
    {
        path: "/user",
        component: require("./components/User.vue").default
    },
    {
        path: "/notFound",
        component: require("./components/NotFound.vue").default
    },
    {
        path: "*",
        component: require("./components/NotFound.vue").default
    }
];

const router = new VueRouter({
    mode: "history",
    routes // short for `routes: routes`
});

Vue.filter("upText", function(text) {
    return text.toUpperCase();
});

Vue.filter("myDate", function(created) {
    return Moment(created).format("MMMM Do YYYY");
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "passport-clients",
    require("./components/passport/Clients.vue").default
);

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue").default
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue").default
);

Vue.component("pagination", require("laravel-vue-pagination"));

window.Fire = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    router,
    data: {
        search: ""
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 1000)
    }
});
