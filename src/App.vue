<template>
    <div id="app" class="w-full bg-grey-lighter h-screen">
        <router-view/>
    </div>
</template>

<script>
import "@/assets/styles/main.css";
import { mapState } from 'vuex';

export default {
    computed: {
        ...mapState(['user']),
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
};
</script>
