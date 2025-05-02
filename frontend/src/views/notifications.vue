<template>
    <div class="Invoice_container flex flex-col w-full h-full gap-4">
    
        <notification_component 
        :notifications="notifications"
        :unreadCount="unreadCount"
        />
         
    </div>
</template>

<script>

import notification_component from '../components/notifications/notification.vue';
import { useNotificationStore } from '../stores/notificationStore';

export default {
    name: 'notifications',
    components: {
        notification_component,
    },
    setup() {
        const notificationStore = useNotificationStore();
        return {
            notificationStore
        }
    },
    data() {
        return {
            notifications: []
        }
    },
    mounted() {
        this.fetchNotifications();
    },
    methods: {
        async fetchNotifications() {
            await this.notificationStore.fetchNotifications();
            this.notifications = this.notificationStore.notifications;
            this.unreadCount = this.notificationStore.unreadCount;
        }
    },
    created(){
        this.fetchNotifications();
    }
}
</script>