import service from '../../service';

export default {
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
        if (! term) {
            context.commit('searchFriend', null);
            return;
        }
        context.commit('searchFriend', service.auth().get('users/search?term='+term));
    },
    addFriend(context, id) {
        service.auth().put('users/invite', {id}).then((xhr) => {
            context.commit('friends', xhr.data.data);
        }).catch((error) => {
            console.log(error);
        });
    },
}