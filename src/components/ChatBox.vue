<template>
    <div class="px-3 py-6 w-2/3 h-full">
        <div class="flex flex-col rounded bg-grey-lighter shadow h-full">
            <div class="flex items-center border-solid border-b border-grey-light p-5" v-if="current">
                <strong class="text-grey-dark text-lg flex-1 flex items-center">
                    <span class="font-normal" v-text="current.name"></span> 
                    <span class="p-1 rounded-full bg-green ml-4" v-show="false"></span>
                </strong>
                <div class="flex text-grey" v-show="false">
                    <i class="fa fa-phone fa-md px-2"></i>
                    <i class="fa fa-video fa-md px-2"></i>
                    <i class="fa fa-ellipsis-v fa-md px-2"></i>
                </div>
            </div>
            <div class="flex-1 w-full px-3 overflow-y-auto" ref="chatContainer">
                <div v-for="chat in conversation">
                    <my-bubble v-if="chat.from == user.id" :message="chat.body"></my-bubble>
                    <others-bubble v-if="chat.from != user.id" :user="current" :message="chat.body"></others-bubble>
                </div>
                <div class="flex justify-center text-grey-darker w-full h-full items-center text-sm" v-if="conversation.length < 1">
                    Start Conversation
                </div>
            </div>
            <div class="rounded bg-white p-2 flex" v-show="current">
                <input type="text" class="flex-1 border-0 px-4 py-2" @keyup="sendMessage" placeholder="Type your message..." ref="message">
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
    mounted() {
        if (this.current) {
            this.scrollToBottom();
            this.focusType();
        }
    },
    data() {
        return {
            conversation: []
        }
    },
    computed: {
        ...mapState(['user', 'current', 'conversations']),
    },
    methods: {
        sendMessage(e) {
            if (e.keyCode == 13) {
                const payload = {
                    type: 'CHAT',
                    from: this.user.id,
                    body: this.$refs.message.value,
                    room: this.current.pivot.room
                };
                this.$store.state.chat.send(`chat/${this.current.pivot.room}`, payload);
                this.$refs.message.value = '';
                this.$store.state.chat.send(`message/${this.current.id}`, {...payload, type: 'MESSAGE'});
            }
        },
        scrollToBottom() {
            this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
        },
        focusType() {
            this.$refs.message.focus();
        },
        startChat() {
            if (this.conversations[this.current.pivot.room]) {
                this.conversation = this.conversations[this.current.pivot.room];
            } else {
                this.conversation = [];
            }

            this.$store.state.chat.client.subscribe(`chat/${this.current.pivot.room}`);
            this.$store.state.chat.client.on('message', (topic, message) => {
                const payload = JSON.parse(message);
                if (payload.type == 'CHAT') {
                    console.log('Pushing...In');
                    this.conversation.push(payload);
                    setTimeout(() => {
                        this.scrollToBottom();
                    }, 10);
                }
            });
        }
    },
    watch: {
        current: {
            handler(value) {
                if (value != null) {
                    setTimeout(() => {
                        this.scrollToBottom();
                        this.focusType();
                        this.startChat();
                    }, 500);
                }
            },
            deep: true
        }
    }
}
</script>
