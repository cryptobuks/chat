<template>
    <a href="javascript:void(0);" class="no-underline" @click="onContactClick(contact)">
        <div class="py-3 px-4" :class="active ? 'bg-grey-light' : 'hover:bg-grey-lighter'">
            <div class="flex items-center">
                <div class="flex items-start mr-4">
                    <img class="w-10 h-10 rounded-full border-2 border-grey-dark" :src="contact.image" :alt="contact.name">
                    <span class="rounded-full bg-blue text-white text-xs unread" v-if="unread"></span>
                </div>
                <div class="text-sm flex flex-col flex-1">
                    <p class="text-grey-darkest font-semibold" v-text="contact.name"></p>
                    <p class="text-grey-dark" v-show="false">...</p>
                </div>
                <div class="text-sm flex flex-col" v-show="false">
                    <div class="flex justify-end mb-2" v-if="online"><span class="rounded-full bg-green text-white p-1 text-xs"></span></div>
                    <p class="text-grey-dark text-xs">Aug 18</p>
                </div>
            </div>
        </div>
    </a>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    props: ['active', 'online', 'unread', 'contact'],
    methods: {
        onContactClick(contact) {
            this.$router.push(`/chat/${contact.pivot.room}`);
            this.startConversation(contact);
        },
        ...mapActions(['startConversation'])
    }
}
</script>

<style lang="css" scoped>
.unread {
    margin-left:-5px;
    padding: 0.30rem;
}
</style>


