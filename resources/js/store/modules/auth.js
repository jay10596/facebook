import User from '../helpers/user'

const state = {
    authUser: '',
    authUserStatus: '',
    authErrors: ''
};

const getters = {
    authUser: state => {
        return state.authUser;
    },

    authUserStatus: state => {
        return state.authUserStatus;
    },

    authErrors: state => {
        return state.authErrors;
    }
};

const actions = {
    loginUser({commit, state}, loginForm) {
        axios.post('/api/login', loginForm)
            .then(res => commit('setLoginResponse', res))
            .catch(err => commit('setAuthErrors', err))
    },

    registerUser({commit, state}, registerForm) {
        axios.post('/api/register', registerForm)
            .then(res => commit('setLoginResponse', res))
            .catch(err => commit('setAuthErrors', err))
    },

    fetchAuthUser({commit, state}) {
        axios.post('/api/me')
            .then(res => commit('setAuthUser', res.data))
            .catch(err => commit('setAuthErrors', err))
    },

    logoutAuthUser({commit, state}) {
        axios.post('/api/logout')
            .then(res => {
                commit('setLogoutResponse')
                commit('setAuthUser', null)
            })
            .catch(err => commit('setAuthErrors', err))
    }
};

const mutations = {
    setLoginResponse(state, res) {
        User.responseAfterLogin(res)
    },

    setAuthUser(state, user) {
        state.authUser = user;
    },

    setLogoutResponse(state) {
        User.logout()
    },

    setAuthErrors(state, err) {
        state.authErrors = err.response.data.errors;
    },
};

export default {
    state, getters, actions, mutations
}
