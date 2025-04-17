
import { defineStore } from 'pinia';
import api from '@/api';

export default defineStore('auth', {
  state() {
    return {
      token: null,
      user: null,
    };
  },
  actions: {
    async login(credentials) {
      const response = await api.post('/login', credentials);
      this.token = response.data.token;
      this.user = response.data.user;
    },
    async fetchUser() {
      const response = await api.get('/user');
      this.user = response.data;
    },
    logout() {
      this.token = null;
      this.user = null;
    },
  },
});
