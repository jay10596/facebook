import Vue from 'vue';
import VueRouter from 'vue-router';
import NewsFeed from "./components/NewsFeed";
import ShowUser from "./components/User/ShowUser";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: NewsFeed, meta:{title: 'News Feed'} },
        { path: '/users/:userId', component: ShowUser, meta:{title: 'Profile'} },
    ],
    mode: 'history',
    hash: false
});
