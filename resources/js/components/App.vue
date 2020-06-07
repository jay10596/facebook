<template>
    <div v-if="authUser" class="flex flex-col h-screen overflow-y-hidden">
        <Navbar />

        <div class="flex flex-1 overflow-y-hidden">
            <Sidebar />

            <div class="w-2/3 overflow-x-hidden">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import Sidebar from "./Sidebar";
    import NewsFeed from "./NewsFeed";
    import { mapGetters } from "vuex";

    export default {
        name: "App",

        components: {NewsFeed, Sidebar, Navbar},

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            }),
        },

        mounted() {
            this.$store.dispatch('fetchAuthUser');
        },

        created() {
            this.$store.dispatch('getPageTitle', this.$route.meta.title)
        },

        watch: {
            $route(to, from) {
                this.$store.dispatch('getPageTitle', to.meta.title)
            }
        }
    }
</script>

<style>

</style>
