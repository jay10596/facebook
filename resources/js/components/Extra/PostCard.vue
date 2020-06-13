<template>
    <div class="w-2/3 bg-white rounded mt-6 shadow">
        <div class="flex flex-col p-4 ">
            <div class="flex justify-between items-center">
                <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + post.posted_by.profile_image.path" alt="Profile Image">

                <div class="flex-auto mx-4">
                    <p class="text-sm font-bold">{{post.posted_by.name}}</p>
                    <p class="text-xs text-gray-600">{{post.created_at}}</p>
                </div>

                <div class="dropdown inline-block relative">
                    <button class="text-xl font-bold px-4 rounded items-center focus:outline-none">...</button>

                    <ul class="dropdown-menu pt-1 absolute hidden text-gray-700 text-sm">
                        <li><button @click="commitEdit(post, $vnode.key)" class="w-24 py-2 px-4 block text-left rounded-t font-semibold bg-gray-400 hover:bg-gray-300 focus:outline-none">Edit</button></li>
                        <li><button @click="dispatchDelete(post.id, $vnode.key)" class="w-24 py-2 px-4 block text-left rounded-b font-semibold bg-gray-400 hover:bg-gray-300 focus:outline-none">Delete</button></li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <p>{{post.body}}</p>
            </div>
        </div>

        <div v-if="post.image">
            <img :src="'/storage/' + post.image" alt="">
        </div>

        <div class="flex justify-between p-4 text-sm">
            <p><i class="far fa-thumbs-up text-blue-500 mr-1"></i>{{post.likes.like_count}} Likes</p>

            <p>{{post.comments.comment_count}} Comments</p>
        </div>

        <div class="flex justify-between items-center m-4 border-1 border-gray-400">
            <button @click="dispatchLike(post.id, $vnode.key)" :class="likeColor"><i class="far fa-thumbs-up mr-1"></i> Like</button>
            <button @click="commentMode = ! commentMode" class="w-full hover:text-gray-600 focus:outline-none"><i class="far fa-comments mr-1"></i> Comments</button>
        </div>

        <div v-if="commentMode" class="flex border-t border-gray-400 p-4 py-2">
            <input v-model='commentBody' type="text" name="comment" placeholder="Add your comment..." class="w-full pl-4 h-8 bg-gray-200 rounded-lg focus:outline-none">

            <button v-if="commentBody" @click="dispatchComment(commentBody, post.id, $vnode.key), commentBody = ''"  class="bg-gray-200 ml-2 px-2 py-1 rounded-lg focus:outline-none">Post</button>
        </div>

        <div v-if="commentMode" v-for="(comment, index) in post.comments.data" class="flex px-4 py-2 items-center">
            <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + comment.commented_by.profile_image.path" alt="Profile Image">

            <div>
                <div class="flex-auto ml-2 bg-gray-200 rounded-lg p-2 text-sm">
                    <router-link :to="'/users/' + comment.commented_by.id" class="font-bold text-blue-700">
                        {{comment.commented_by.name}}
                    </router-link>

                    <p class="inline">{{comment.body}}</p>
                </div>

                <p class="text-xs ml-4">{{comment.created_at}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostCard",

        props: ['post'],

        data() {
            return {
                commentBody: '',
                commentMode: false,
            }
        },

        computed: {
            likeColor() {
                return this.post.likes.user_liked ? 'w-full text-blue-500 focus:outline-none' : 'w-full hover:text-blue-500 focus:outline-none'
            }
        },

        methods: {
            dispatchDelete(post_id, index) {
                this.$store.dispatch('deletePost', {post_id, index})
            },

            dispatchLike(post_id, index) {
                this.$store.dispatch('likeDislikePost', {post_id, index})
            },

            dispatchComment(body, post_id, index) {
                this.$store.dispatch('addComment', {body, post_id, index})
            },

            commitEdit(post, index) {
                this.$store.commit('splicePost', {post, index})

                EventBus.$emit('changingEditMode', post)
            }
        }
    }
</script>

<style scoped>
    .dropdown:hover .dropdown-menu {
        display: block;
    }
</style>
