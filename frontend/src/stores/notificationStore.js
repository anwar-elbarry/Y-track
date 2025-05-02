import { defineStore } from 'pinia';
import notificationService from '../services/notificationService';

export const useNotificationStore = defineStore('notifications', {
    state: () => ({
        notifications: [],
        unreadCount: 0,
    }),

    actions: {
        async fetchNotifications() {
            const data = await notificationService.getNotifications();
            this.notifications = data.notifications;
            this.unreadCount = this.notifications.filter(n => !n.is_read).length;
        },

        async markAsRead(notificationId) {
            await notificationService.markAsRead(notificationId);
            await this.fetchNotifications();
        },

    }
});