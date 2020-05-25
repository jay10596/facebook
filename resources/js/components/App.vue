<template>
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <Navbar />

        <div class="flex flex-1 overflow-y-hidden">
            <Sidebar />

            <div class="w-2/3 overflow-x-hidden">
                <NewsFeed />
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import Sidebar from "./Sidebar";
    import NewsFeed from "./NewsFeed";

    export default {
        name: "App",

        components: {NewsFeed, Sidebar, Navbar},
    }
</script>

<style>

</style>
