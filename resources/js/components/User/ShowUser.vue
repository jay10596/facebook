<template>
    <div v-if="user">
        <div class="relative">
            <div class="w-100 h-64 overflow-hidden z-10">
                <UploadableImage :newImage="user.cover_image" imageClass="object-cover w-full" imageAlt="Cover Image" imageWidth="1500" imageHeight="500" imageType="cover"/>
            </div>

            <div class="absolute flex items-center bottom-0 left-0 -mb-8 z-20 mx-4">
                <UploadableImage :newImage="user.profile_image" imageClass="w-32 h-32 object-cover rounded-full shadow-lg border-4 border-gray-200" imageAlt="Profile Image" imageWidth="750" imageHeight="750" imageType="profile"/>

                <p class="text-2xl text-gray-100 ml-3 shadow-2xl">{{user.name}}</p>
            </div>

            <div class="absolute flex items-center bottom-0 right-0 mb-4 z-20 mx-4">
                <button v-if="friendButton && friendButton !== 'Accept'" @click="sendFriendRequest" class="py-1 px-3 bg-gray-400 rounded">
                    <i class="fas fa-user-plus"></i> {{friendButton}}
                </button>

                <button v-if="friendButton && friendButton === 'Accept'" @click="acceptFriendRequest" class="py-1 px-3 bg-blue-500 mr-2 rounded">
                    <i class="fas fa-user-check"></i> Accept
                </button>

                <button v-if="friendButton && friendButton === 'Accept'" @click="deleteFriendRequest" class="py-1 px-3 bg-gray-400 mr-2 rounded">
                    <i class="fas fa-user-times"></i> Delete
                </button>
            </div>
        </div>

        <div class="flex flex-col items-center py-4">
            <p v-if="status.posts == 'loading' && posts.length < 1">Loading Posts...</p>

            <PostCard v-else v-for="(post, index) in posts" :key="index" :post="post"/>
        </div>
    </div>
</template>

<script>
    import PostCard from "../Extra/PostCard";
    import UploadableImage from "../Extra/UploadableImage";
    import { mapGetters } from 'vuex'

    export default {
        name: "ShowUser",

        components: {PostCard, UploadableImage},

        computed: {
            ...mapGetters({
                user: 'user',
                posts: 'posts',
                friendButton: 'friendButton',
                userErrors: 'userErrors',
                status: 'status'
            })
        },

        mounted() {
            this.$store.dispatch('fetchUser', this.$route.params.userId)
            this.$store.dispatch('fetchUserPosts', this.$route.params.userId)
        },

        methods: {
            sendFriendRequest() {
                this.$store.dispatch('sendRequest', this.$route.params.userId)
            },

            acceptFriendRequest() {
                this.$store.dispatch('acceptRequest', this.$route.params.userId)
            },

            deleteFriendRequest() {
                this.$store.dispatch('deleteRequest', this.$route.params.userId)
            }
        }
    }
</script>

<style scoped>

</style>
