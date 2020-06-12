const state = {
    authUser: '',
    authUserStatus: ''
};

const getters = {
    authUser: state => {
        return state.authUser;
    }
};

const actions = {
    fetchAuthUser({commit, state}) {
        axios.post('/api/me')
            .then(res => commit('setAuthUser', res.data.success))
            .catch(err => 'Unable to catch the user.')
    }
};

const mutations = {
    setAuthUser(state, user) {
        state.authUser = user;
    }
};

export default {
    state, getters, actions, mutations
}
