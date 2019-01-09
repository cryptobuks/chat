<template>
    <div id="app" class="w-full bg-grey-lighter h-screen">
        <router-view/>
        <modal v-if="wait" :persisted="true" width="w-20">
            <i class="fa fa-spinner fa-fw fa-spin fa-lg text-grey-darker"></i>
        </modal>
    </div>
</template>

<script>
import "@/assets/styles/main.css";
import Modal from '@/components/Modal.vue';
import { mapState } from 'vuex';

export default {
    components: {Modal},
    computed: {
        ...mapState(['user', 'wait']),
    },
    watch: {
        user: {
            handler(newUser) {
                if (newUser) {
                    // this.$router.replace('/chat');
                } else {
                    this.$router.replace('/');
                }
            },
            deep: true
        }
    },
};
</script>
