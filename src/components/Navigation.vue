<template>
    <nav class="flex bg-blue justify-between items-center p-4 shadow-md">
        <router-link class="no-underline text-white ml-2" to="/chat">
            <i class="fa fa-comments fa-lg"></i>
        </router-link>
        <div class="flex items-center">
            <a href="#" class="no-underline text-white mr-4 text-lg" v-show="false">
                <i class="fa fa-search"></i>
            </a>
            <div class="flex items-center">
                <img :src="user.image" :alt="user.name" class="w-10 rounded-full">
                <div class="flex flex-col text-white mx-4">
                    <span class="text-sm mb-2" v-text="user.name"></span>
                    <button class="flex text-xs justify-between text-grey-light font-semibold" @click="logout">
                        <span>Logout</span>
                        <span class="fa fa-chevron-right"></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    computed: {
        ...mapState(['user'])
    },
    methods: {
        logout() {
            window.sessionStorage.removeItem('loggedInUser');
            this.logOutUser();
        },
        ...mapActions(['logOutUser'])
    }
}
</script>

