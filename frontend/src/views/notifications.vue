<template>
    <div class="Invoice_container flex flex-col w-full h-full gap-4">
    
        <notification_component 
        :notifications="notifications"
        :unreadCount="unreadCount"
        :threshold_alert="threshold_alert"
        :currency="currency"
        @threshold_alert="updateThresholdAlert"
        />
         
    </div>
</template>

<script>

import notification_component from '../components/notifications/notification.vue';
import { useNotificationStore } from '../stores/notificationStore';
import useAuthStore  from '../stores/auth';
const authStore = useAuthStore();
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
            notifications: [],
            unreadCount: 0,
            threshold_alert: authStore.user.threshold_alert,
            currency: authStore.user.currency,
        }
    },
    methods: {
        async fetchNotifications() {
            await this.notificationStore.fetchNotifications();
            this.notifications = this.notificationStore.notifications;
            this.unreadCount = this.notificationStore.unreadCount;
        },
        async updateThresholdAlert(newThreshold) {
            this.threshold_alert = newThreshold;
            await authStore.updateUser({'threshold_alert': newThreshold});
        }
    },
    created(){
        this.fetchNotifications();
    }
}
</script>