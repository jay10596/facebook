<template>
    <div class="w-2/3 p-4 bg-white shadow rounded">
        <div class="flex justify-between items-center">
            <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + authUser.profile_image.path" alt="Profile Image">

            <input v-if="! editMode" v-model="postForm.body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <input v-else v-model="post.body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <div v-if="! editMode">
                <transition name="fade">
                    <button v-if="postForm.body" @click="postMessage" class="px-2 text-xl">
                        <i class="fas fa-share"></i>
                    </button>
                </transition>

                <button class="w-8 h-8 rounded-full text-xl bg-gray-200">
                    <i class="fas fa-image"></i>
                </button>
            </div>

            <div v-else>
                <transition name="fade">
                    <button v-if="post.body" @click="updateMessage(post), post.body='', editMode = false" class="px-2 text-xl">
                        <i class="fas fa-edit"></i>
                    </button>
                </transition>

                <button @click="commitCancelEdit(post), editMode = false" class="w-8 h-8 rounded-full text-xl bg-gray-200">
                    <i class="far fa-window-close"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash";
    import { mapGetters } from 'vuex';

    export default {
        name: "CreatePost",

        data() {
            return {
                editMode: false,
                post: '',
                originalPost: ''
            }
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            }),

            postForm: {
                get() {
                    return this.$store.getters.postForm;
                },
                //_.debounce (function is to make sure the form is not updated after every character that user types.
                set: _.debounce (function(postForm) {
                    return this.$store.commit('updatePostForm', postForm);
                }, 1000)
            }
        },

        created() {
            EventBus.$on('changingEditMode', (post) => {
                this.editMode = true
                this.post = post
                this.originalBody = post.body
            })
        },

        methods: {
            postMessage() {
                this.$store.dispatch('createPost')
            },

            updateMessage(post) {
                this.$store.dispatch('updatePost', post)
            },

            commitCancelEdit(post) {
                post.body = this.originalBody

                this.$store.commit('cancelEdit', post)
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
