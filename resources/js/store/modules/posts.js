const state = {
    allPosts: '',
    allPostsStatus: '',
    postForm: {
        body: '',
    },
};

const getters = {
    allPosts: state => {
        return state.allPosts;
    },

    allPostsStatus: state => {
        return state.allPostsStatus;
    },

    postForm: state => {
        return state.postForm;
    }
};

const actions = {
    fetchAllPosts({commit, state}) {
        commit('setAllPostsStatus', 'loading')

        axios.get('api/posts')
            .then(res => {
                commit('setAllPosts', res.data.data)
                commit('setAllPostsStatus', 'success')
            })
            .catch(err => commit('setAllPostsStatus', 'error'))
    },

    createPost({commit, state}) {
        axios.post('api/posts', state.postForm)
            .then(res => {
                commit('pushPost', res.data)
                commit('updatePostForm', '')
            })
            .catch(err => commit('setAllPostsStatus', 'error'))
    },

    likeDislikePost({commit, state}, data) {
        axios.post('api/posts/' + data.post_id + '/like-dislike')
            .then(res => {
                commit('pushLikes', {likes: res.data, index: data.index})
            })
            .catch(err => commit('setAllPostsStatus', 'error'))
    },
};

const mutations = {
    setAllPosts(state, posts) {
        state.allPosts = posts;
    },

    setAllPostsStatus(state, status) {
        state.allPostsStatus = status;
    },

    updatePostForm(state, postForm) {
        state.postForm = postForm;
    },

    pushPost(state, newPost) {
        state.allPosts.unshift(newPost.data);
    },

    pushLikes(state, data) {
        state.allPosts[data.index].likes = data.likes;
    },
};

export default {
    state, getters, actions, mutations
}
