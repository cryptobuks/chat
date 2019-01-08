<template>
    <div class="py-3 flex justify-end">
        <div class="rounded-full bg-white p-3 text-grey-darker text-sm mr-4" v-text="message"></div>
        <img class="w-10 h-10 rounded-full" :src="user.image" :alt="user.name">
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    props: ['message'],
    computed: {
        ...mapState(['user'])
    }
}
</script>
