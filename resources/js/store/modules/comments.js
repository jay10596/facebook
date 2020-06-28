import Posts from './posts'

const state = {
    //Unlike posts, we will pass the body from the vue file as a parameter (Just to do it differently)
    commentErrors: null,
};

const getters = {
    commentErrors: state => {
        return state.commentErrors;
    },
};

const actions = {
    addComment({commit, state}, data) {
        axios.post('/api/posts/' + data.post_id + '/comments', {body: data.body})
            .then(res => {
                commit('pushComments', {comments: res.data, index: data.index})
            })
            .catch(err => commit('setCommentErrors', err))
    },

    deleteComment({commit, state}, data) {
        axios.delete('/api/posts/' + data.post_id + '/comments/' + data.comment_id)
            .then(res => {
                commit('spliceComment', data)
            })
            .catch(err => commit('setCommentErrors', err))
    },
};

const mutations = {
    setCommentErrors(state, err) {
        state.commentErrors = err.response
    },

    pushComments(state, data) {
        Posts.state.posts[data.index].comments = data.comments
    },

    spliceComment(state, data) {
        Posts.state.posts[data.post_index].comments.data.splice(data.comment_index, 1)
    },
};

export default {
    state, getters, actions, mutations
}
