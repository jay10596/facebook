import Vue from 'vue';
import VueRouter from 'vue-router';

import User from './store/helpers/user'
import NewsFeed from "./components/Main/NewsFeed";
import ShowUser from "./components/User/ShowUser";

let homeTitle = 'Sign Up';

if(User.loggedIn()) {
    homeTitle = 'NewsFeed'
}

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: NewsFeed, meta:{title: homeTitle} },
        { path: '/users/:userId', component: ShowUser, meta:{title: 'Profile'} },
    ],
    mode: 'history',
    hash: false
});
