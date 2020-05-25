<template>
    <div class="flex flex-col items-center py-4">
        <CreatePost />
    </div>
</template>

<script>
    import CreatePost from "./Post/CreatePost";

    export default {
        name: "NewsFeed",

        components: {CreatePost}
    }
</script>

<style scoped>

</style>
