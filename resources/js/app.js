import Vue from 'vue';
import router from './router';
import App from './components/App';
import store from './store';
import User from './store/helpers/user.js';

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

window.User = User
window.EventBus = new Vue();
window.Vue = require('vue');

console.log(User.id());

require('./bootstrap');

const app = new Vue({
    el: '#app',

    components: {
        App
    },
    router,
    store
});
