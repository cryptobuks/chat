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
import {mapState} from 'vuex';

export default {
    components: {Navigation, Contacts, ChatBox},
    beforeMount() {
        if (! window.sessionStorage.getItem('loggedInUser')) {
            this.$router.replace('/');
        }
    },
    computed: {
        ...mapState(['user'])
    }
};
</script>
