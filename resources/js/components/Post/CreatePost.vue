<template>
    <div class="w-2/3 p-4 bg-white shadow rounded">
        <div class="flex justify-between items-center">
            <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + authUser.profile_image.path" alt="Profile Image">

            <input v-if="! editMode" v-model="body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <input v-else v-model="post.body" type="text" class="flex-auto mx-4 h-8 pl-4 rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Add a post">

            <div v-if="! editMode">
                <transition name="fade">
                    <button v-if="body" @click="postMessage" class="px-2 text-xl">
                        <i class="fas fa-share"></i>
                    </button>
                </transition>
            </div>

            <div v-else>
                <transition name="fade">
                    <button v-if="post.body" @click="updateMessage(post), post.body=''" class="px-2 text-xl">
                        <i class="fas fa-edit"></i>
                    </button>
                </transition>

                <button @click="commitCancelEdit(post)" class="w-8 h-8 rounded-full text-xl bg-gray-200">
                    <i class="far fa-window-close"></i>
                </button>
            </div>

            <button ref="postImage" class="dz-clickable mx-2 w-8 h-8 rounded-full text-xl bg-gray-200 focus:outline-none">
                <p class="dz-clickable"><i class="fas fa-image"></i></p>
            </button>
        </div>

        <div v-if="editMode && post.single_picture">
            <img :src="'/storage/' + post.single_picture.path" class="w-full h-full my-4" alt="">
        </div>

        <div v-if="editMode && post.multiple_pictures" class="flex">
            <div v-for="picture in post.multiple_pictures.data" id="picture.id" class="mr-1 mt-5">
                <img :src="'/storage/' + picture.path" alt="Post Picture">
            </div>
        </div>

        <div class="dropzone-previews flex">
            <div id="dz-template" class="hidden">
                <div class="dz-preview dz-file-preview mt-4">
                    <div class="dz-details mr-1">
                        <img data-dz-thumbnail class="w-32 h-32" alt="">

                        <button data-dz-remove class="mt-2 ml-6 text-sm focus:outline-none"> <i class="fas fa-minus-circle text-red-500"></i> Remove</button>
                    </div>

                    <div class="dz-progress">
                        <span class="dz-upload" data-dz-upload></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash";
    import { mapGetters } from 'vuex';
    import Dropzone from 'dropzone';

    export default {
        name: "CreatePost",

        data() {
            return {
                editMode: false,
                post: '',
                originalPost: '',
                dropzone: null,
            }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.postImage, this.settings);
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            }),

            imageButtonClass() {
                 if(this.editMode) {
                     return 'hidden'
                 } else {
                     return 'dz-clickable mx-2 w-8 h-8 rounded-full text-xl bg-gray-200 focus:outline-none'
                 }
            },

            body: {
                get() {
                    return this.$store.getters.body;
                },
                //_.debounce (function is to make sure the form is not updated after every character that user types.
                set: _.debounce (function(body) {
                    return this.$store.commit('setPostBody', body);
                }, 1000)
            },

            settings() {
                return {
                    paramName: 'image', //field name is image
                    url: '/api/upload-pictures',
                    acceptedFiles: 'image/*',
                    clickable: '.dz-clickable', //<i> will not work as it is not a button. To make sure all the inner elements of button are clickable.
                    autoProcessQueue: false, //When the image is uploaded, it sends it right away which will give the error becasue we do not have the body in params.
                    previewsContainer: '.dropzone-previews',
                    previewTemplate: document.querySelector('#dz-template').innerHTML,
                    maxFiles: 5,
                    parallelUploads: 5,
                    uploadMultiple:true,
                    params: { //Cannot pass body here because settings() load when the component is mounted. Use sending.
                        'width': 750,
                        'height': 750,
                    },
                    headers: {
                        //'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content, (For api, when token is not needed)

                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    sending: (file, xhr, postForm) => {
                        postForm.append('body', this.post.body || this.$store.getters.body)
                        postForm.append('post_id', this.post.id)
                    },
                    success: (e, res) => {
                        this.dropzone.removeAllFiles()

                        this.$store.commit('setPostBody', '')

                        //this.$store.commit('pushPost', res) For multiple images post, it will commit the response multiple times.
                        this.$store.dispatch('fetchAllPosts')
                    },
                    maxfilesexceeded: file => {
                        this.dropzone.removeAllFiles()

                        this.dropzone.addFile(file)
                    }
                }
            },
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
                if (this.dropzone.getAcceptedFiles().length) {
                    this.dropzone.processQueue()
                } else {
                    this.$store.dispatch('createPost')
                }
            },

            updateMessage(post) {
                this.editMode = false

                if (this.dropzone.getAcceptedFiles().length) {
                    this.dropzone.processQueue()
                } else {
                    this.$store.dispatch('updatePost', post)
                }
            },

            commitCancelEdit(post) {
                this.editMode = false

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
