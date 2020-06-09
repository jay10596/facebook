import Vue from 'vue';
import Vuex from 'vuex';
import User from './modules/user.js'
import Title from './modules/title.js'
import Profile from './modules/profile.js'
import Posts from './modules/posts.js'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        User,
        Title,
        Profile,
        Posts
    }
});
