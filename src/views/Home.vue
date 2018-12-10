<template>
    <div class="flex flex-col h-full">
        <Navigation :logged-in="false"></Navigation>
    </div>
</template>

<script>
import Navigation from '@/components/Navigation.vue';

export default {
    components: {Navigation}
};
</script>
