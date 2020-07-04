const state = {
    posts: '',
    postStatus: '',
    postErrors: null,
    body: '',
};

const getters = {
    posts: state => {
        return state.posts;
    },

    postStatus: state => {
        return state.postStatus;
    },

    postErrors: state => {
        return state.postErrors;
    },

    body: state => {
        return state.body;
    }
};

const actions = {
    fetchAllPosts({commit, state}) {
        commit('setPostStatus', 'loading')

        axios.get('api/posts')
            .then(res => {
                commit('setPosts', res.data.data)
                commit('setPostStatus', 'success')
            })
            .catch(err => commit('setPostErrors', err))
    },

    fetchUserPosts({commit, state}, id) {
        axios.get('/api/users/' + id)
            .then(res => {
                commit('setPosts', res.data[1].data)
                commit('setPostStatus', 'success')
            })
            .catch(err => commit('setPostErrors', err))
    },

    createPost({commit, state}) {
        axios.post('/api/posts', {body: state.body})
            .then(res => {
                commit('pushPost', res.data)
                commit('setPostBody', '')
            })
            .catch(err => commit('setPostErrors', err))
    },

    updatePost({commit, state}, post) {
        axios.put('/api/posts/' + post.id, {body: post.body, image: post.image})
            .then(res => {
                commit('pushPost', res.data)
                commit('setPostBody', '')
            })
            .catch(err => commit('setPostErrors', err))
    },

    deletePost({commit, state}, data) {
        axios.delete('/api/posts/' + data.post_id)
            .then(res => {
                commit('splicePost', data)
            })
            .catch(err => commit('setPostErrors', err))
    },

    likeDislikePost({commit, state}, data) {
        axios.post('/api/posts/' + data.post_id + '/like-dislike')
            .then(res => {
                commit('pushLikes', {likes: res.data, index: data.index})
            })
            .catch(err => commit('setPostErrors', err))
    },
};

const mutations = {
    setPosts(state, posts) {
        state.posts = posts
    },

    setPostStatus(state, status) {
        state.postStatus = status
    },

    setPostErrors(state, err) {
        state.postErrors = err.response
    },

    setPostBody(state, body) {
        state.body = body
    },

    pushPost(state, newPost) {
        state.posts.unshift(newPost.data)
    },

    splicePost(state, data) {
        state.posts.splice(data.index, 1)
    },

    cancelEdit(state, post) {
        state.posts.unshift(post)
    },

    pushLikes(state, data) {
        state.posts[data.index].likes = data.likes
    },
};

export default {
    state, getters, actions, mutations
}
