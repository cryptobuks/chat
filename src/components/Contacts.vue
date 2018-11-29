<template>
    <div class="px-3 py-6 w-1/3 h-full">
        <div class="flex flex-col rounded bg-white shadow-md h-full">
            <div class="pt-4 px-4">
                <div class="flex justify-between items-center border-solid border-b border-grey-light pb-3">
                    <strong class="text-blue text-lg">Chat</strong>
                    <button class="font-semibold rounded py-2 px-4 bg-grey-light text-grey-dark">NEW</button>
                </div>
            </div>

            <div class="flex flex-col overflow-y-auto flex-1">
                <contact-item :online="true" :unread="true"></contact-item>
                <contact-item :active="true" :online="true"></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
                <contact-item></contact-item>
            </div>
        </div>
    </div>
</template>

<script>
import ContactItem from '@/components/ContactItem.vue';

export default {
    components: {ContactItem}
}
</script>
