<template>
    <div class="py-3 flex justify-start">
        <img class="w-10 h-10 rounded-full" :src="user.image" alt="user.name">
        <div class="rounded-full bg-white p-3 text-grey-darker text-sm ml-4" v-text="message"></div>
    </div>
</template>

<script>
export default {
    props: ['message', 'user']
}
</script>

