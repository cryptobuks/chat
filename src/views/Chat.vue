<template>
    <div class="flex flex-col h-full">
        <Navigation></Navigation>
        <div class="flex h-full px-3">
            <contacts></contacts>
            <router-view></router-view>
            <div class="px-3 py-6 w-2/3 h-full" v-if="!$route.params.room">
                <div class="flex flex-col rounded bg-grey-lighter shadow h-full">
                    <div class="flex-1 w-full px-3 overflow-y-auto">
                        <div class="flex justify-center text-grey-darker w-full h-full items-center text-sm">
                            Start Conversation
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navigation from '@/components/Navigation.vue';
import Contacts from '@/components/Contacts.vue';
import {mapState, mapActions} from 'vuex';
import auth from '../services/auth';

export default {
    components: {Navigation, Contacts},
    beforeMount() {
        if (! auth.check()) {
            this.$router.replace('/');
        } else {
            this.$store.commit('login', auth.user());
        }
        // Getting friends...
        this.getFriendList(this.$route.params.room);
    },
    computed: {
        ...mapState(['conversations', 'user', 'current'])
    },
    mounted() {
        this.$store.state.chat.client.subscribe(`message/${this.user.id}`);
        this.$store.state.chat.client.subscribe(`friend/${this.user.id}`);

        this.$store.state.chat.client.on('message', (topic, message) => {
            const payload = JSON.parse(message);
            switch(payload.type) {
                case 'CHAT':
                    this.conversations[payload.room].push(payload);
                    break;
                case 'FRIEND':
                    this.getFriendList();
                    break;
                case 'MESSAGE':
                    if (this.current && this.current.pivot.room != payload.room) {
                        // Background message.
                        this.conversations[payload.room].push(payload);
                    }
                    break;
            }
        });
    },
    methods: {
        ...mapActions(['getFriendList'])
    },
};
</script>
