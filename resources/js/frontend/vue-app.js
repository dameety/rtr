window.Vue = require("vue");
Vue.prototype.$restaurant = window.restaurant;


import router from './router'
import App from "./pages/App";
import store from '@/store';
import VueCurrencyFilter from 'vue-currency-filter'
import axios from "@/services/axios";
import BootstrapVue from "bootstrap-vue";
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.component('ValidationErrorsDisplay', require('@/components/ValidationErrorsDisplay').default);

Vue.use(VueCurrencyFilter, {
    symbol : '$',
    thousandsSeparator: ',',
    fractionCount: 2,
    fractionSeparator: '.',
    symbolPosition: 'front',
    symbolSpacing: true
});


const files = require.context('./../filters', true, /\.js$/i);
files.keys().map(key => Vue.filter(key.split('/').pop().split('.')[0], files(key).default));


Vue.prototype.$http = axios;

new Vue({
    render: h => h(App),
    router,
    store
}).$mount("#app");
