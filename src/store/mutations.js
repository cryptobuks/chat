import Chat from "../services/chat";
import store from ".";

export default {
    login(state, user) {
        state.user = user;
        state.chat = new Chat(user.id);
    },
    logout(state) {
        state.user = null;
    },
    friends(state, friends) {
        state.friends = friends;
        store.commit('initConversations', friends);
    },
    notifyFriend(state, id) {
        if (state.chat) {
            state.chat.send(`friend/${id}`, {
                type: 'FRIEND',
            });
        }
    },
    searchFriend(state, promise) {
        state.searchFriend = promise;
    },
    current(state, user) {
        state.current = user;
    },
    setCurrent(state, data) {
        const current = data.friends.filter(item => item.pivot.room == data.room);
        if (current.length > 0) {
            state.current = current[0];
        }
    },
    wait(state, what) {
        state.wait = what;
    },
    initConversations(state, friends) {
        friends.forEach(item => {
            state.conversations[item.pivot.room] = [];
        });
    },
};