<template>
    <div class="flex flex-col items-center py-4">
        <CreatePost />

        <ShowPosts />
    </div>
</template>

<script>
    import CreatePost from "../Post/CreatePost";
    import ShowPosts from "../Post/ShowPosts";

    export default {
        name: "NewsFeed",

        components: {CreatePost, ShowPosts}
    }
</script>

<style scoped>

</style>
