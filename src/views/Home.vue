<template>
    <div class="home">
        <Navigation></Navigation>
        <Contacts></Contacts>
    </div>
</template>

<script>
import Navigation from '@/components/Navigation.vue';
import Contacts from '@/components/Contacts.vue';

export default {
    components: {Navigation, Contacts}
};
</script>
