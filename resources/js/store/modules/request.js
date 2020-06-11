const state = {
    user: '',
    userStatus: null,
    userErrors: ''
};

const getters = {
    user: state => {
        return state.user;
    },

    friendship: state => { //Just an alias. Not mandatory.
        return state.user.friendship;
    },

    friendButton: (state, getters, rootState)=> {
        if(rootState.Auth.user.id == state.user.id) {
            return;
        } else if (getters.friendship == null) {
            return 'Add Friend';
        } else if (getters.friendship.confirmed_at == null
            && getters.friendship.friend_id !== rootState.User.user.id) {
            return 'Pending Request';
        } else if (getters.friendship.confirmed_at !== null)
            return '';

        return 'Accept'
    },

    userErrors: state => {
        return state.userErrors;
    },

    status: state => {
        return {
            user: state.userStatus,
        };
    },
};

const actions = {
    fetchUser({commit, state}, id) {
        axios.get('/api/users/' + id)
            .then(res => {
                commit('setUser', res.data[0])
                commit('setStatus', 'loading')
            })
            .catch(err => commit('setUserErrors', err))
    },

    sendRequest({commit, state}, id) {
        axios.post('/api/send-request', {'friend_id': id})
            .then(res => commit('setUserFriendship', res.data))
            .catch(err => commit('setUserErrors', err))
    },

    acceptRequest({commit, state}, id) {
        axios.post('/api/confirm-request', {'user_id': id})
            .then(res => commit('setUserFriendship', res.data.data))
            .catch(err => commit('setUserErrors', err))
    },

    deleteRequest({commit, state}, id) {
        axios.post('/api/delete-request', {'user_id': id})
            .then(res => commit('setUserFriendship', null))
            .catch(err => commit('setUserErrors', err))
    },
};

const mutations = {
    setUser(state, user) {
        state.user = user
    },

    setStatus(state, status) {
        state.userStatus = status
    },

    setUserFriendship(state, friendship) {
        state.user.friendship = friendship
    },

    setUserErrors(state, err) {
        state.userErrors = err.response;
    },
};

export default {
    state, getters, actions, mutations
}
