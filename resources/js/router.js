import Vue from 'vue';
import VueRouter from 'vue-router';
import NewsFeed from "./components/NewsFeed";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: NewsFeed},
    ],
    mode: 'history',
    hash: false
});
