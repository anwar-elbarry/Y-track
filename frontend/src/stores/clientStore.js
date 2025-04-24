import { defineStore } from "pinia";
import api from "../api";

export const useClientStore = defineStore('client',{
    state : () => ({
        clients : [],
        loading : false,
        error : null
    }),
    actions: {
        async fetchClients() {
          this.loading = true
          try {
            const response = await api.get('/api/client/index')
            console.log(response.data.clients);
            this.clients = response.data.clients
          } catch (error) {
            this.error = error
          } finally {
            this.loading = false
          }
        },
        
        async addclient(clientData) {
          this.loading = true
          try {
            const response = await api.post('/api/client/create', clientData)
            this.clients.push(response.data.client)
            console.log(response.data.client);
            console.log(response.data.message);
            return response.data
          } catch (error) {
            this.error = error
            throw error
          } finally {
            this.loading = false
          }
        },
        
        async removeclient(id) {
          try {
            const response = await api.delete(`/api/client/remove/${id}`)
            this.clients = this.clients.filter(client => client.id !== id)
            console.log(this.clients);
            console.log(response.data.message);
          } catch (error) {
            this.error = error
            throw error
          }
        },
    
        async updateclient(id, clientData) {
          this.loading = true
          try {
            const response = await api.put(`/api/client/update/${id}`, clientData)
            const index = this.clients.findIndex(client => client.id === id)
            if (index !== -1) {
              this.clients[index] = response.data.client
            }
            console.log(response.data.client);
            console.log(response.data.message);
            return response.data
          } catch (error) {
            this.error = error
            throw error
          } finally {
            this.loading = false
          }
        }
      },
    
})