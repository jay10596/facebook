const state = {
    user: '',
    userStatus: ''
};

const getters = {
    authUser: state => {
        return state.user;
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
        state.user = user;
    }
};

export default {
    state, getters, actions, mutations
}
