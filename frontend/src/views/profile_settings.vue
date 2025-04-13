<template>
    <div class="incomes_container w-full h-full gap-4">
        <profile_settings />
    </div>
</template>

<script>

import Profile_settings from '../components/profile/profile_settings.vue';

export default {
    name: 'ProfileSettings',
    components: {
        Profile_settings
    },
}
</script>