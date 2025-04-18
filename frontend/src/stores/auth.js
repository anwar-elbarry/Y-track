
import { defineStore } from 'pinia';
import api from '../api';

export default defineStore('auth', {
  state() {
    return {
      token: localStorage.getItem("token" || null),
      user: JSON.parse(localStorage.getItem("user") || null) ,
      message: null,
    };
  },
  actions: {
    async login(credentials) {
      const response = await api.post('/api/auth/signin', credentials);
      this.message = response.data.message;

      this.setAuth(response.data.user, response.data.token);

    },
    async fetchUser() {
      const response = await api.get('/user');
      this.user = response.data;
    },
    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem("user");
      localStorage.removeItem("token");
    },
    setAuth(user, token) {
      localStorage.setItem('user', JSON.stringify(user));
      localStorage.setItem('token', token);
      this.user = user;
      this.token = token;
    }
  },
});
