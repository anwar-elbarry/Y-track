
import { defineStore } from 'pinia';
import api from '../api';
import router from '../router';

export default defineStore('auth', {
  state() {
    return {
      token: localStorage.getItem("token" || null),
      user : {},
      statistics : {},
      message: null,
    };
  },
  actions: {
    async login(credentials) {
      const response = await api.post('/api/auth/signin', credentials);
      this.message = response.data.message;
      this.setAuth(response.data.token);

    },
    async fetchUser() {
      const response = await api.get('api/auth/user');
      this.user = response.data.user;
    },
    async logout() {
      localStorage.removeItem("token");
      router.push('/auth');
    },
    setAuth(token) {
      localStorage.setItem('token', token);
      this.token = token;
    },
   async changePassword(data){
      const response  = await api.put('/api/auth/changePassword',data);
      console.log(response.data.message);
      if(response.data.isUpdated){
        return this.message = 'password Updated successfully';
      }
      return this.message = 'faill to update password'
    },
   async updateUser(data){
      const response  = await api.put('/api/auth/updateUser',data);
      console.log(response.data.message);
      if(response.data.isUpdated){
        this.user = response.data.user;

        return this.message = 'user Updated successfully';
      }
      return this.message = 'faill to update user'
    },
    async getStatistics(){
        const response = await api.get('api/statistics/index');
        this.statistics = response.data.statistics
    }
  },
});
