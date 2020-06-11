const state = {
    posts: '',
    postStatus: '',
    postErrors: null,
    postForm: {
        body: '',
    },
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

    postForm: state => {
        return state.postForm;
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
        axios.post('/api/posts', state.postForm)
            .then(res => {
                commit('pushPost', res.data)
                commit('updatePostForm', '')
            })
            .catch(err => commit('setPostErrors', err))
    },

    updatePost({commit, state}, post) {
        axios.put('/api/posts/' + post.id, {body: post.body})
            .then(res => {
                commit('pushPost', res.data)
                commit('updatePostForm', '')
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

    addComment({commit, state}, data) {
        axios.post('/api/posts/' + data.post_id + '/comments', {body: data.body})
            .then(res => {
                commit('pushComments', {comments: res.data, index: data.index})
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

    updatePostForm(state, postForm) {
        state.postForm.body = postForm
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

    pushComments(state, data) {
        state.posts[data.index].comments = data.comments
    },
};

export default {
    state, getters, actions, mutations
}
