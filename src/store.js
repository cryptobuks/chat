import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';

Vue.use(Vuex);
let API_BASE = 'http://localhost/chatter/public/';

export default new Vuex.Store({
    state: {
        user: null,
        friends: [],
        searchFriend: null,
    },
    mutations: {
        login(state, user) {
            state.user = user;
        },
        logout(state) {
            state.user = null;
        },
        friends(state, friends) {
            state.friends = friends;
        },
        searchFriend(state, promise) {
            state.searchFriend = promise;
        }
    },
    actions: {
        loginUser(context, user) {
            Axios.post(API_BASE + 'api/users', user).then((response) => {
                // eslint-disable-next-line
                context.commit('login', response.data.data);
            }).catch((error) => {
                // eslint-disable-next-line
                console.log(error);
            });
        },
        logOutUser(context) {
            context.commit('logout');
        },
        getFriendList(context) {
            Axios.get(API_BASE + 'api/users').then((response) => {
                let data = response.data;
                if (! data.status) {
                    // eslint-disable-next-line
                    console.log(data.message);
                }
                context.commit('friends', data.data);
            });
        },
        searchFriends(context, term) {
            context.commit('searchFriend', Axios.get(API_BASE + 'api/users/search', {term}));
        },
        addFriend(context, id) {
            Axios.put(API_BASE + 'api/users/invite', {id}).then((xhr) => {
                context.commit('friends', xhr.data.data);
            }).catch((error) => {
                // eslint-disable-next-line
                console.log(error);
            });
        }
    }
})
