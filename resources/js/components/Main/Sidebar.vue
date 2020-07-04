<template>
    <div class="w-1/3 p-4 bg-white border-r-2 border-gray-400 shadow-sm">
        <button @click="dispatchLogout" class="text-xl font-bold tracking-tight focus:outline-none"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>
</template>

<script>
    export default {
        name: "Sidebar",

        methods: {
            dispatchLogout() {
                this.$store.dispatch('logoutAuthUser')
            }
        }
    }
</script>

<style scoped>

</style>
