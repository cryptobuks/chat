<template>
    <div class="fixed w-full h-screen pin flex justify-center items-center">
        <div @click.self="close" class="z-20 fixed pin overflow-auto bg-grey-darkest opacity-75 flex">
        </div>
        <div class="z-40 opacity-100 w-1/3 rounded flex flex-col">
            <div class="flex justify-end">
                <button @click="close" class="text-grey-darkest bg-white w-8 h-8 rounded-full close-button z-50">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="p-8 bg-white rounded shadow-inner">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        close() {
            this.$emit('close');
        }
    }
}
</script>

<style>
    .close-button {
        margin-right: -1rem;
        margin-bottom: -1rem;
    }
</style>

