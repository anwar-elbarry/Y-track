<template>
    <div class="Invoice_container flex flex-col w-full h-full gap-4">
    
        <notification_component />
         
    </div>
</template>

<script>

import notification_component from '../components/notifications/notification.vue';

export default {
    name: 'notifications',
    components: {
        notification_component,
    },
}
</script>