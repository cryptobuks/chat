<template>
    <div class="px-3 py-6 w-2/3 h-full">
        <div class="flex flex-col rounded bg-grey-lighter shadow h-full">
            <div class="flex items-center border-solid border-b border-grey-light p-5">
                <strong class="text-grey-dark text-lg flex-1 flex items-center">
                    <span class="font-normal" v-text="user.name"></span> 
                    <span class="p-1 rounded-full bg-green ml-4"></span>
                </strong>
                <div class="flex text-grey" v-show="false">
                    <i class="fa fa-phone fa-md px-2"></i>
                    <i class="fa fa-video fa-md px-2"></i>
                    <i class="fa fa-ellipsis-v fa-md px-2"></i>
                </div>
            </div>
            <div class="flex-1 w-full px-3 overflow-y-auto" ref="chatContainer">
                <div class="flex justify-center text-grey-darker mt-6 text-sm" v-if="conversation.length < 1">
                    Start Conversation
                </div>
            </div>
            <div class="rounded bg-white p-2 flex">
                <input type="text" class="flex-1 border-0 px-4 py-2" placeholder="Type your message..." ref="message">
                <button class="text-grey mx-4"><i class="fa fa-paperclip fa-lg"></i></button>
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
            conversation: [],
        }
    },
    mounted() {
        this.scrollToBottom();
        this.focusType();
    },
    computed: {
        ...mapState(['user'])
    },
    methods: {
        scrollToBottom() {
            this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
        },
        focusType() {
            this.$refs.message.focus();
        }
    }
}
</script>
