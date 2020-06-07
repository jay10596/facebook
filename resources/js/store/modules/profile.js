const state = {
    user: '',
    posts: '',
    errors: '',
    userStatus: null,
    postsStatus: null
};

const getters = {
    user: state => {
        return state.user;
    },
    posts: state => {
        return state.posts;
    },
    friendship: state => { //Just an alias. Not mandatory.
        return state.user.friendship;
    },
    friendButton: (state, getters, rootState)=> {
        if(rootState.User.user.id == state.user.id) {
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
    errors: state => {
        return state.errors;
    },
    status: state => {
        return {
            user: state.userStatus,
            posts: state.postsStatus
        };
    },
};

const actions = {
    fetchUserAndPosts({commit, state}, id) {
        axios.get('/api/users/' + id)
            .then(res => {
                commit('setUser', res.data[0])
                commit('setPosts', res.data[1].data)
                commit('setStatus', 'loading')
            })
            .catch(err => commit('setErrors', err))
    },

    sendRequest({commit, state}, id) {
        axios.post('/api/send-request', {'friend_id': id})
            .then(res => commit('setUserFriendship', res.data))
            .catch(err => {})
    },

    acceptRequest({commit, state}, id) {
        axios.post('/api/confirm-request', {'user_id': id})
            .then(res => commit('setUserFriendship', res.data.data))
            .catch(err => {})
    },

    deleteRequest({commit, state}, id) {
        axios.post('/api/delete-request', {'user_id': id})
            .then(res => commit('setUserFriendship', null))
            .catch(err => {})
    },
};

const mutations = {
    setUser(state, user) {
        state.user = user
    },

    setPosts(state, posts) {
        state.posts = posts
    },

    setErrors(state, err) {
        state.errors = err.response;
    },

    setUserFriendship(state, friendship) {
        state.user.friendship = friendship
    },

    setStatus(state, status) {
        state.userStatus = status
        state.postsStatus = status
    },
};

export default {
    state, getters, actions, mutations
}
