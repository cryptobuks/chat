<template>
    <div id="app" class="w-full bg-grey-lighter h-screen">
        <transition name="slide">
            <router-view/>
        </transition>
    </div>
</template>

<script>
import "@/assets/styles/main.css";

export default {};
</script>
