import Chat from "../../services/chat";

export default {
    startConversation(context, user) {
        context.commit('current', user);
    }
}