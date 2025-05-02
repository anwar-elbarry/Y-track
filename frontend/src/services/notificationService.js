import api from '../api';

const notificationService = {
    // Récupérer les notifications
    async getNotifications() {
        try {
            const response = await api.get('/api/notifications/index');
            return response.data;
        } catch (error) {
            console.error('Error fetching notifications:', error);
            return [];
        }
    },

    // Marquer une notification comme lue
    async markAsRead(notificationId) {
        try {
            await api.put(`/api/notifications/${notificationId}/read`);
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    },

    // Mettre à jour les paramètres de notification
    async updateSettings(settings) {
        try {
            await api.put('/api/notification-settings', settings);
        } catch (error) {
            console.error('Error updating notification settings:', error);
        }
    }
};

export default notificationService;