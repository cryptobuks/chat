export default {
    startConversation(context, user) {
        context.commit('current', user);
    }
}