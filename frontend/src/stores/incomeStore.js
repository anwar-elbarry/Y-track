import { defineStore } from 'pinia'
import api from '../api'

export const useIncomeStore = defineStore('income', {
  state: () => ({
    incomes: [],
    loading: false,
    error: null
  }),
  
  actions: {
    async fetchIncomes() {
      this.loading = true
      try {
        const response = await api.get('/api/income/index')
        console.log(response.data.incomes);
        this.incomes = response.data.incomes
      } catch (error) {
        this.error = error
      } finally {
        this.loading = false
      }
    },
    
    async addIncome(incomeData) {
      this.loading = true
      try {
        const response = await api.post('/api/income/create', incomeData)
        this.incomes.push(response.data.income)
        console.log(response.data.income);
        console.log(response.data.message);
        return response.data
      } catch (error) {
        this.error = error
        throw error
      } finally {
        this.loading = false
      }
    },
    
    async removeIncome(id) {
      try {
        await api.delete(`/api/income/remove/${id}`)
        this.incomes = this.incomes.filter(income => income.id !== id)
        console.log(this.incomes);
        console.log(response.data.message);
      } catch (error) {
        this.error = error
        throw error
      }
    },

    async updateIncome(id, incomeData) {
      this.loading = true
      try {
        const response = await api.put(`/api/income/update/${id}`, incomeData)
        const index = this.incomes.findIndex(income => income.id === id)
        if (index !== -1) {
          this.incomes[index] = response.data.income
        }
        console.log(response.data.income);
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

  getters: {
    totalIncome: (state) => state.incomes.reduce((sum, income) => sum + income.amount, 0),
    monthlyIncome: (state) => {
      const currentMonth = new Date().getMonth()
      return state.incomes
        .filter(income => new Date(income.date).getMonth() === currentMonth)
        .reduce((sum, income) => sum + income.amount, 0)
    }
  }
})
