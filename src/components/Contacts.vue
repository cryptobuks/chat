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
                <contact-item v-for="friend in friends" :key="friend.id"></contact-item>
                <div class="flex flex-col justify-center items-center py-8" v-if="friends.length < 1">
                    <p class="text-sm text-grey-darkest mb-6">No friends?</p>
                    <button class="text-blue" @click="openModal">Add Friends</button>
                </div>
            </div>
        </div>
        <modal v-show="showModal" @close="closeModal">
            <div class="text-grey-darkest">
                <h4 class="text-lg text-grey-darkest mb-6">Invite Friend</h4>
                <div class="flex">
                    <input v-model="term" type="text" placeholder="Type your friend's email" class="px-4 py-2 rounded border border-grey-light flex-1">
                    <button class="font-semibold rounded py-2 px-4 bg-grey-light text-grey-dark" @click="search">Search</button>
                </div>
                <div class="flex mt-4 justify-center" v-if="loading">
                    <i class="fa fa-sync-alt fa-spin"></i>
                </div>
                <div class="flex" v-if="!loading">
                    <div v-for="item in searchResults" :key="item.id" class="w-full">
                        <div class="flex items-center mt-4 cursor-pointer hover:bg-grey-lighter p-2" @click="startConversation(item)">
                            <div class="flex items-start mr-4">
                                <img class="w-6 h-6 rounded-full" :src="item.image" alt="item.name">
                            </div>
                            <p class="text-grey-darkest font-semibold text-sm" v-text="item.name"></p>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import ContactItem from '@/components/ContactItem.vue';
import Modal from '@/components/Modal.vue';
import { mapActions, mapState } from 'vuex';

export default {
    components: {ContactItem, Modal},
    data() {
        return {
            term: null,
            showModal: false,
            loading: false,
            searchResults: []
        }
    },
    computed: {
        ...mapState(['friends', 'searchFriend'])
    },
    mounted() {
        this.getFriendList();
    },
    methods: {
        ...mapActions(['getFriendList', 'searchFriends', 'addFriend']),
        closeModal() {
            this.showModal = false;
        },
        openModal() {
            this.showModal = true;
        },
        startConversation(user) {
            // eslint-disable-next-line
            this.showModal = false;
            this.term = null;
            this.searchResults = [];

            this.addFriend(user.id);
        },
        search() {
            this.searchFriends();
            this.loading = true;
            this.searchFriend.then((xhr) => {
                let response = xhr.data;
                this.searchResults = response.data;
            }).then(() => {
                this.loading = false;
            });
        }
    }
}
</script>
