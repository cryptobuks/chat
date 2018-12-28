export default {
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
};