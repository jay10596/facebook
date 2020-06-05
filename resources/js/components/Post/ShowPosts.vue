<template>
    <div class="flex flex-col items-center py-4">
        <PostCard v-for="post in posts" :key="post.id" :post="post"/>
    </div>
</template>

<script>
    import PostCard from "../Extra/PostCard";

    export default {
        name: "ShowPosts",

        components: {PostCard},

        data() {
            return {
                posts: null,
            }
        },

        created() {
            axios.get('api/posts')
                .then(res => this.posts = res.data.data)
        }
    }
</script>

<style scoped>

</style>
