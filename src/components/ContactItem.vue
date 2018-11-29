<template>
    <div class="py-3 px-4" :class="active ? 'bg-grey-light' : ''">
        <div class="flex items-center">
            <div class="flex items-start mr-4">
                <img class="w-10 h-10 rounded-full border-2 border-grey-dark" src="https://s.gravatar.com/avatar/7afb9eba1ef1d116446bf242efc8b64f?s=80" alt="Avatar">
                <span class="rounded-full bg-blue text-white text-xs unread" v-if="unread"></span>
            </div>
            <div class="text-sm flex flex-col flex-1">
                <p class="leading-none mb-2">Kazi Mainuddin</p>
                <p class="text-grey-dark">How are you? And ...</p>
            </div>
            <div class="text-sm flex flex-col">
                <div class="flex justify-end mb-2" v-if="online"><span class="rounded-full bg-green text-white p-1 text-xs"></span></div>
                <p class="text-grey-dark text-xs">Aug 18</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['active', 'online', 'unread'],
}
</script>

<style lang="css" scoped>
.unread {
    margin-left:-5px;
    padding: 0.30rem;
}
</style>


