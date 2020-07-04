<template>
    <div class="flex items-center bg-white h-12 border-b border-gray-400 shadow-sm">
        <div class="flex justify-start items-center">
            <router-link to="/" class="ml-12 mr-2 text-4xl text-blue-500">
                <i class="fab fa-facebook"></i>
            </router-link>

            <div class="relative">
                <div class="absolute mx-2 text-xl text-gray-600">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" class="w-56 h-8 pl-10 text-sm rounded-full bg-gray-200 focus:outline-none focus:shadow-outline" placeholder="Search...">
            </div>
        </div>

        <div class="w-full flex justify-center items-center h-full">
            <router-link to="/" class="flex items-center h-full px-6 text-2xl border-b-2 border-white hover:border-blue-500 hover:text-blue-500">
                <i class="fas fa-home"></i>
            </router-link>

            <router-link :to="'/users/' + authUser.id" class="flex items-center h-full px-6 border-b-2 border-white hover:border-blue-500">
                <img class="w-8 h-8 object-cover rounded-full" :src="'/storage/' + authUser.profile_image.path" alt="Profile Image">
            </router-link>

            <router-link to="/" class="flex items-center h-full px-6 text-2xl border-b-2 border-white hover:border-blue-500 hover:text-blue-500">
                <i class="fab fa-facebook-messenger"></i>
            </router-link>
        </div>

        <div class="w-1/3 flex justify-end mr-12">
            <router-link to="/" class="text-2xl">
                <i class="fas fa-cog"></i>
            </router-link>
        </div>
    </div>
</template/>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: "Navbar",

        computed: {
            ...mapGetters({
                authUser: 'authUser'
            })
        }
    }
</script>

<style scoped>

</style>
