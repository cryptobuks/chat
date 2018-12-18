<template>
    <modal v-show="showModal" @close="closeModal">
        <div class="text-grey-darkest">
            <h4 class="text-lg text-grey-darkest mb-6">Invite Friend</h4>
            <div class="flex">
                <input v-model="term" type="text" @keyup="searchKeyUp" placeholder="Type your friend's email or name" class="px-4 py-2 rounded border border-grey-light flex-1">
                <button class="font-semibold rounded py-2 px-4 bg-grey-light text-grey-dark" @click="search">Search</button>
            </div>
            <div class="flex mt-4 justify-center" v-if="loading">
                <i class="fa fa-sync-alt fa-spin"></i>
            </div>
            <div class="flex" v-if="!loading">
                <div v-for="item in searchResults" :key="item.id" class="w-full">
                    <div class="flex items-center mt-4 cursor-pointer hover:bg-grey-lighter p-2" @click="inviteUser(item)">
                        <div class="flex items-start mr-4">
                            <img class="w-8 h-8 rounded-full" :src="item.image" alt="item.name">
                        </div>
                        <div>
                            <p class="text-grey-darkest font-semibold text-sm" v-text="item.name"></p>
                            <span class="text-xs text-grey-dark" v-text="item.email"></span>
                        </div>
                    </div>
                </div>
                <div class="flex w-full justify-center mt-4 p-2" v-if="searchResults.length < 1">
                    <span class="text-sm text-grey">No results found</span>
                </div>
            </div>
        </div>
    </modal>
</template>

<script>
import Modal from '@/components/Modal.vue';
import { mapActions, mapState } from 'vuex';

export default {
    components: {Modal},
    props: ['showModal'],
    data() {
        return {
            term: null,
            loading: false,
            searchResults: []
        }
    },
    computed: {
        ...mapState(['searchFriend'])
    },
    methods: {
        inviteUser(user) {
            this.$emit('close');
            this.term = null;
            this.searchResults = [];

            this.addFriend(user.id);
        },
        searchKeyUp(e) {
            if (e.keyCode == 13) {
                this.search();
            }
        },
        search() {
            if (! this.term) {
                return;
            }
            this.searchFriends(this.term);
            this.loading = true;
            this.searchFriend.then((xhr) => {
                let response = xhr.data;
                this.searchResults = response.data;
            }).then(() => {
                this.loading = false;
            });
        },
        closeModal() {
            this.$emit('close');
        },
        ...mapActions(['searchFriends', 'addFriend'])
    }
}
</script>
