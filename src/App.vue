<template>
    <div id="app" class="w-full bg-grey-lighter h-screen">
        <transition name="slide">
            <router-view/>
        </transition>
    </div>
</template>

<script>
import "@/assets/styles/main.css";
import { mapActions, mapState } from 'vuex';

export default {
    mounted() {
        if (window.sessionStorage.getItem('loggedInUser')) {
            this.loginUser(JSON.parse(window.sessionStorage.getItem('loggedInUser')));
        }
    },
    computed: {
        ...mapState(['user'])
    },
    watch: {
        user: {
            handler(newUser) {
                if (newUser) {
                    this.$router.replace('/chat');
                } else {
                    this.$router.replace('/');
                }
            },
            deep: true
        }
    },
    methods: {
        ...mapActions(['loginUser'])
    }
};
</script>
