import Vue from 'vue';
import Vuex from 'vuex';
import state from './state';
import mutations from './mutations';
import friends from './actions/friends';
import conversation from './actions/conversation';
import authentication from './actions/authentication';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        ...state,
    },
    mutations: {
        ...mutations,
    },
    actions: {
        ...authentication,
        ...friends,
        ...conversation,
    }
});
