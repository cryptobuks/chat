<template>
    <div class="px-3 py-6 w-2/3 h-full">
        <div class="flex flex-col rounded bg-grey-lighter shadow h-full">
            <div class="flex items-center border-solid border-b border-grey-light p-5">
                <strong class="text-grey-dark text-lg flex-1 flex items-center">
                    <span class="font-normal" v-text="currentUser.name"></span> 
                    <span class="p-1 rounded-full bg-green ml-4" v-show="false"></span>
                </strong>
                <div class="flex text-grey" v-show="false">
                    <i class="fa fa-phone fa-md px-2"></i>
                    <i class="fa fa-video fa-md px-2"></i>
                    <i class="fa fa-ellipsis-v fa-md px-2"></i>
                </div>
                <div class="flex text-grey">
                    <button type="button" class="text-grey" @click="onCloseClick">
                        <i class="fa fa-times fa-md px-2"></i>
                    </button>
                </div>
            </div>
            <div class="flex-1 w-full px-3 overflow-y-auto" ref="chatContainer">
                <div v-for="chat in conversation">
                    <my-bubble v-if="chat.from.id == user.id" :message="chat.body"></my-bubble>
                    <others-bubble v-if="chat.from.id != user.id" :user="chat.from" :message="chat.body"></others-bubble>
                </div>
            </div>
            <div class="rounded bg-white p-2 flex">
                <input type="text" class="flex-1 border-0 px-4 py-2" @keyup="typeMessage" placeholder="Type your message..." ref="message">
                <button class="text-grey mx-4"><i class="fa fa-paperclip fa-lg" v-show="false"></i></button>
                <button class="bg-blue rounded-full text-white w-10 h-10">
                    <i class="fa fa-paper-plane fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import MyBubble from '@/components/MyBubble.vue';
import OthersBubble from '@/components/OthersBubble.vue';
import { mapState } from 'vuex';

export default {
    components: {MyBubble, OthersBubble},
    data() {
        return {
            conversation: []
        };
    },
    updated() {
        const roomId = this.$route.params.room;
        this.conversation = this.conversations[roomId];
        this.scrollToBottom();
    },
    mounted() {
        this.scrollToBottom();
        this.$refs.message.focus();

        this.subscribe(this.$route.params.room);
    },
    computed: {
        ...mapState(['current', 'user', 'conversations']),
        currentUser() {
            if (! this.current) {
                return { name: null, image: null };
            }
            return this.current;
        }
    },
    methods: {
        typeMessage(e) {
            if (e.keyCode == 13) {
                this.sendMessage();
            }
        },
        scrollToBottom() {
            this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
        },
        sendMessage() {
            const payload = {
                type: 'CHAT',
                from: this.user,
                body: this.$refs.message.value,
                room: this.current.pivot.room
            };
            this.$refs.message.value = '';
            this.$store.state.chat.send(`chat/${this.current.pivot.room}`, payload);
            this.$store.state.chat.send(`message/${this.current.id}`, {...payload, type: 'MESSAGE'});
        },
        onCloseClick() {
            this.$router.replace('/chat');
            this.unsubscribe(this.current.pivot.room);
        },
        subscribe(roomId) {
            console.log(`Subscribing to: ${roomId}`);
            this.$store.state.chat.client.subscribe(`chat/${roomId}`);
        },
        unsubscribe(roomId) {
            console.log(`Un-Subscribing from: ${roomId}`);
            this.$store.state.chat.client.unsubscribe(`chat/${roomId}`);
        }
    },
    watch: {
        current: {
            handler(item, old) {
                if (old) {
                    this.unsubscribe(old.pivot.room);
                }
                this.subscribe(item.pivot.room);
                setTimeout(this.scrollToBottom, 100);
                this.$refs.message.focus();
            },
            deep: true
        },
    }
}
</script>
