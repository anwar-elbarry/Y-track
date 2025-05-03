import api from '../api';

const notificationService = {
    async getNotifications() {
        try {
            const response = await api.get('/api/notifications/index');
            return response.data;
        } catch (error) {
            console.error('Error fetching notifications:', error);
            return [];
        }
    },

    async markAsRead(notificationId) {
        try {
            await api.put(`/api/notifications/markAsRead/${notificationId}`);
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    },
};

export default notificationService;