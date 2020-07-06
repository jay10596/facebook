const state = {
    title: 'Welcome',
};

const getters = {
    title: state => {
        return state.title;
    }
};

const actions = {
    getPageTitle({commit}, title) {
        commit('setTitle', title);
    }
};

const mutations = {
    setTitle(state, title) {
        state.title = title + ' | Facebook';

        document.title = state.title;
    }
};

export default {
    state, getters, actions, mutations
}
