import api from '../api';

const adminService = {
    async getAllUsers(){
        const response = await api.get('api/admin/users');
        console.log(response.data.users);
        return response.data.users;
    },
    
    async getDashboardStats(){
        const response = await api.get('api/admin/dashboard/stats');
        return response.data;
    },
    
    async updateUserStatus(userId, status){
        const response = await api.put(`api/admin/users/${userId}/status`, { status });
        return response.data;
    },
    
    async deleteUser(userId){
        const response = await api.delete(`api/admin/users/${userId}`);
        return response.data;
    }
};

export default adminService;