<template>
    <div>
        <img :class="imageClass" :src="'/storage/' + imageObject.path" :alt="imageAlt" ref="userImage">
    </div>
</template>

<script>
    import Dropzone from 'dropzone';
    import { mapGetters } from 'vuex';

    export default {
        name: "UploadableImage",

        props: ['newImage', 'imageClass', 'imageAlt', 'imageWidth', 'imageHeight', 'imageType'],

        data() {
            return {
                dropzone: null,
                uploadedImage: null
            }
        },

        mounted() {
            if(this.authUser.id == this.$route.params.userId) {
                this.dropzone = new Dropzone(this.$refs.userImage, this.settings);
            }
        },

        computed: {
            ...mapGetters({
                authUser: 'authUser',
            }),

            settings() {
                return {
                    paramName: 'image', //field name is image
                    url: '/api/upload-images',
                    acceptedFiles: 'image/*',
                    params: {
                        'width': this.imageWidth,
                        'height': this.imageHeight,
                        'type' : this.imageType
                    },
                    headers: {
                        //'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,

                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    success: (e, res) => {
                        //alert('uploaded!');
                        /*  One Way

                            this.cover_image = res will not work because we can not mutate the props.
                            The image will change in the profile but not in posts, comments and navbar.

                            this.uploadedImage = res.data
                         */
                        this.$store.dispatch('fetchAuthUser')
                        this.$store.dispatch('fetchUser', this.$route.params.userId)
                        this.$store.dispatch('fetchUserPosts', this.$route.params.userId)
                    }
                };
            },

            //Tt is not required if we are dispatching events because as we are not changing uploadedImage, it will call this.newImage anyway. Just change it on the :scr at the top.
            imageObject() {
                return this.uploadedImage || this.newImage
            }
        }

    }
</script>

<style scoped>

</style>
