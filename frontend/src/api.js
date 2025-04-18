// api.js
import axios from "axios";
import useAuthStore from './stores/auth'; 

const api = axios.create({
  baseURL: 'http://localhost:8000',
  headers: {
    'Content-Type': 'application/json'
  },
  withCredentials: true  
});

//  request interceptor
api.interceptors.request.use((config) => {
  const authStore = useAuthStore(); // get the store instance
  if (authStore.token) {
    config.headers.Authorization = `Bearer ${authStore.token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

export default api;
