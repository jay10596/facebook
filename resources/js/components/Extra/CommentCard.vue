<template>
    <div class="flex px-4 py-2 items-center">
        <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + comment.commented_by.profile_image.path" alt="Profile Image">

        <div>
            <div class="flex-auto ml-2 bg-gray-200 rounded-lg p-2 text-sm">
                <router-link :to="'/users/' + comment.commented_by.id" class="font-bold text-blue-700">
                    {{comment.commented_by.name}}
                </router-link>

                <p v-if="! commentEditMode" class="inline">{{comment.body}}</p>

                <div v-else class="inline ml-2">
                    <input v-model="comment.body" class="outline-none px-2 border border-gray-400"></input>

                    <button @click="dispatchEditComment(comment.id, comment_index, comment.body, comment.post_id, post_index), commentEditMode = false" class="ml-2 text-gray-700 focus:outline-none"><i class="fas fa-check-circle"></i></button>

                    <button @click="commentEditMode = false, comment.body = orginalCommentBody" class="ml-2 text-gray-700 focus:outline-none"><i class="fas fa-ban"></i></button>
                </div>
            </div>

            <div class="flex text-xs">
                <button @click="commentEditMode = ! commentEditMode" class="ml-4 font-medium text-blue-700 hover:font-semibold focus:outline-none">Edit</button>

                <button @click="dispatchDeleteComment(comment.id, comment_index, comment.post_id, post_index)" class="ml-4 font-medium text-blue-700 hover:font-semibold focus:outline-none">Delete</button>

                <p class="ml-4 text-xs">{{comment.updated_at}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CommentCard",

        props: ['comment', 'comment_index', 'post_index'],

        data() {
            return {
                orginalCommentBody: this.comment.body,
                commentEditMode: false,
            }
        },

        methods: {
            dispatchEditComment(comment_id, comment_index, comment_body, post_id, post_index) {
                this.$store.dispatch('updateComment', {comment_id, comment_index, comment_body, post_id, post_index})
            },

            dispatchDeleteComment(comment_id, comment_index, post_id, post_index) {
                this.$store.dispatch('deleteComment', {comment_id, comment_index, post_id, post_index})
            }
        }
    }
</script>

<style scoped>

</style>
