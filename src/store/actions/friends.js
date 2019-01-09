import request from '../../services/request';
import store from '..';

export default {
    getFriendList(context, room = null) {
        context.commit('wait', true);
        if (store.state.friends.length > 0) {
            context.commit('setCurrent', {friends: store.state.friends, room});
            context.commit('wait', false);
            return;
        }
        request.auth().get('users').then((response) => {
            let data = response.data;
            if (! data.status) {
                console.log(data.message);
            }
            context.commit('friends', data.data);
            context.commit('setCurrent', {friends: data.data, room});
            context.commit('wait', false);
        });
    },
    searchFriends(context, term) {
        if (! term) {
            context.commit('searchFriend', null);
            return;
        }
        context.commit('searchFriend', request.auth().get('users/search?term='+term));
    },
    addFriend(context, id) {
        request.auth().put('users/invite', {id}).then((xhr) => {
            context.commit('friends', xhr.data.data);
            context.commit('notifyFriend', id);
        }).catch((error) => {
            console.log(error);
        });
    },
}