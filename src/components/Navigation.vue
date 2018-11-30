<template>
    <nav class="flex bg-blue justify-between items-center p-4 shadow-md">
        <a href="#" class="no-underline text-white ml-2">
            <i class="fa fa-bars fa-lg"></i>
        </a>
        <div class="flex items-center">
            <a href="#" class="no-underline text-white mr-4 text-lg">
                <i class="fa fa-search"></i>
            </a>
            <div class="flex items-center" v-if="loggedIn">
                <img src="https://s.gravatar.com/avatar/7afb9eba1ef1d116446bf242efc8b64f?s=80" alt="Image" class="w-10 rounded-full">
                <div class="flex flex-col text-white mx-4">
                    <span class="text-sm mb-2">Kazi Mainuddin</span>
                    <div class="flex text-xs justify-between text-grey-light font-semibold">
                        <span>Available</span>
                        <span class="fa fa-chevron-down"></span>
                    </div>
                </div>
            </div>
            <div class="flex flex-center" v-if="!loggedIn">
                <a href="#" class="rounded-full px-6 py-2 border text-white border-white text-sm no-underline hover:bg-white hover:text-blue mr-2">Login</a>
                <a href="#" class="rounded-full px-6 py-2 border text-white border-white text-sm no-underline hover:bg-white hover:text-blue">Register</a>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: ['loggedIn']
}
</script>

