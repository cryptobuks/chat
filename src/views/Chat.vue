<template>
    <div class="flex flex-col h-full">
        <Navigation></Navigation>
        <div class="flex h-full px-3">
            <contacts></contacts>
            <chat-box></chat-box>
        </div>
    </div>
</template>

<script>
import Navigation from '@/components/Navigation.vue';
import Contacts from '@/components/Contacts.vue';
import ChatBox from '@/components/ChatBox.vue';
import {mapState, mapActions} from 'vuex';
import auth from '../services/auth';

export default {
    components: {Navigation, Contacts, ChatBox},
    beforeMount() {
        if (! auth.check()) {
            this.$router.replace('/');
        } else {
            this.$store.commit('login', auth.user());
        }
    },
    mounted() {
        if (this.$store.state.chat) {
            this.$store.state.chat.client.subscribe(`message/${this.user.id}`);
            this.$store.state.chat.client.subscribe(`friend/${this.user.id}`);

            this.$store.state.chat.client.on('message', (topic, message) => {
                const payload = JSON.parse(message);
                if (payload.type == 'MESSAGE') {
                    const currentId = this.current ? this.current.id : null;
                    if (payload.from != currentId && payload.from != this.user.id) {
                        console.log('Pushing...Out');
                        if (! this.$store.state.conversations[payload.room]) {
                            this.$store.state.conversations[payload.room] = [];
                        }
                        this.$store.state.conversations[payload.room].push(payload);
                    }
                } else if (payload.type == 'FRIEND') {
                    this.getFriendList();
                }
            });
        }
    },
    computed: {
        ...mapState(['user', 'current'])
    },
    methods: {
        ...mapActions(['getFriendList'])
    },
};
</script>
