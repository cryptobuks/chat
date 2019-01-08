import Chat from "../services/chat";

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
    wait(state, what) {
        state.wait = what;
    },
};