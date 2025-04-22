import { defineStore } from 'pinia'
import api from '../api'

export const useTransactionStore = defineStore('transaction', {
  state: () => ({
    transactions: [],
    loading: false,
    error: null
  }),
  
  actions: {
    async fetchtransactions() {
      this.loading = true
      try {
        const response = await api.get('/api/transaction/index')
        console.log(response.data.transactions);
        this.transactions = response.data.transactions
      } catch (error) {
        this.error = error
      } finally {
        this.loading = false
      }
    },
    
    async removetransaction(id) {
      try {
        await api.delete(`/api/transaction/remove/${id}`)
        this.transactions = this.transactions.filter(transaction => transaction.id !== id)
        console.log(this.transactions);
        console.log(response.data.message);
      } catch (error) {
        this.error = error
        throw error
      }
    },
  },
})
