import Vue from 'vue';
import Vuex from 'vuex';
import auth from './auth';
import service from './service';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        friends: [],
        searchFriend: null,
        current: null,
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
        },
        current(state, user) {
            state.current = user;
        }
    },
    actions: {
        loginUser(context, user) {
            service.api().post('users', user).then((response) => {
                let user = response.data.data;
                auth.login(user);
                context.commit('login', user);
            }).catch((error) => {
                console.log(error);
            });
        },
        logOutUser(context) {
            auth.logout();
            context.commit('logout');
        },
        getFriendList(context) {
            service.auth().get('users').then((response) => {
                let data = response.data;
                if (! data.status) {
                    console.log(data.message);
                }
                context.commit('friends', data.data);
            });
        },
        searchFriends(context, term) {
            context.commit('searchFriend', service.auth().get('users/search?term='+term));
        },
        addFriend(context, id) {
            service.auth().put('users/invite', {id}).then((xhr) => {
                context.commit('friends', xhr.data.data);
            }).catch((error) => {
                console.log(error);
            });
        },
        startConversation(context, user) {
            context.commit('current', user);
        }
    }
})
