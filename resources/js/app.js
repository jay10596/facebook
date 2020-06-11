import Vue from 'vue';
import router from './router';
import App from './components/App';
import store from './store';

window.EventBus = new Vue();

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'


require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',

    components: {
        App
    },
    router,
    store
});
