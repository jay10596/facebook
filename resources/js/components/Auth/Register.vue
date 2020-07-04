<template>
    <div class="flex h-screen items-center justify-center">
        <div class="w-full max-w-xs">
            <form @submit.prevent="dispatchRegister(registerForm)" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>

                    <input v-model="registerForm.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">

                    <p v-if="authErrors && authErrors.meta.name" class="text-red-500 text-xs italic">{{authErrors.meta.name[0]}}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>

                    <input v-model="registerForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username">

                    <p v-if="authErrors && authErrors.meta.email" class="text-red-500 text-xs italic">{{authErrors.meta.email[0]}}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>

                    <input v-model="registerForm.password" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">

                    <p v-if="authErrors && authErrors.meta.password" class="text-red-500 text-xs italic">{{authErrors.meta.password[0]}}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>

                    <input v-model="registerForm.confirm_password" class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">

                    <p v-if="authErrors && authErrors.meta.confirm_password" class="text-red-500 text-xs italic">{{authErrors.meta.confirm_password[0]}}</p>
                </div>

                <div class="flex items-center justify-between">
                    <a @click="changeRegisterMode" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#"> < Back To Log In!</a>

                    <button @click="dispatchRegister(registerForm)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Register",

        data() {
            return {
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    confirm_password: ''
                }
            }
        },

        computed: {
            ...mapGetters({
                authErrors: 'authErrors'
            })
        },

        methods: {
            changeRegisterMode() {
                EventBus.$emit('changingRegisterMode')
            },

            dispatchRegister(registerForm) {
                this.$store.dispatch('registerUser', registerForm)
            }
        }
    }
</script>

<style>

</style>
