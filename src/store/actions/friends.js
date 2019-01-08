import request from '../../services/request';

export default {
    getFriendList(context) {
        request.auth().get('users').then((response) => {
            let data = response.data;
            if (! data.status) {
                console.log(data.message);
            }
            context.commit('friends', data.data);
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