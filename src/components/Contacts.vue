<template>
    <div class="px-3 py-6 w-1/3 h-full">
        <div class="flex flex-col rounded bg-white shadow-md h-full">
            <div class="pt-4 px-4">
                <div class="flex justify-between items-center border-solid border-b border-grey-light pb-3">
                    <strong class="text-blue text-lg">Chat</strong>
                    <button class="font-semibold rounded py-2 px-4 bg-grey-light text-grey-dark" @click="openModal">NEW</button>
                </div>
            </div>

            <div class="flex flex-col overflow-y-auto flex-1">
                <contact-item v-for="friend in friends" :key="friend.id" :contact="friend" :active="friend.id == currentId"></contact-item>
                <div class="flex flex-col justify-center items-center py-8" v-if="friends.length < 1">
                    <p class="text-sm text-grey-darkest mb-6">No friends?</p>
                    <button class="text-blue" @click="openModal">Add Friends</button>
                </div>
            </div>
        </div>
        <invite :show-modal="showModal" @close="closeModal"></invite>
    </div>
</template>

<script>
import ContactItem from '@/components/ContactItem.vue';
import { mapActions, mapState } from 'vuex';
import Invite from '@/components/Invite.vue';

export default {
    components: {ContactItem, Invite},
    data() {
        return {
            showModal: false,
        }
    },
    computed: {
        ...mapState(['friends', 'current']),
        currentId() {
            if (this.current) {
                return this.current.id;
            }
            return null;
        }
    },
    mounted() {
        this.getFriendList();
    },
    methods: {
        ...mapActions(['getFriendList']),
        closeModal() {
            this.showModal = false;
        },
        openModal() {
            this.showModal = true;
        },
    }
}
</script>
