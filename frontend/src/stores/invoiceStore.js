import { defineStore } from 'pinia'
import api from '../api'

export const useInvoiceStore = defineStore('invoice', {
  state: () => ({
    invoices: [],
    error: null
  }),
  
  actions: {
    async fetchinvoices() {
      this.loading = true
      try {
        const response = await api.get('/api/invoice/index')
        console.log(response.data.invoices);
        this.invoices = response.data.invoices
      } catch (error) {
        this.error = error
      } finally {
        this.loading = false
      }
    },
    
    async addInvoice(invoiceData) {
      try {
        const response = await api.post('/api/invoice/create', invoiceData)
        this.invoices.push(response.data.invoice)
        console.log(response.data.invoice);
        console.log(response.data.message);
        console.log(response.data.invoicePath);
        return response.data
      } catch (error) {
        this.error = error
        throw error
      } finally {
        this.loading = false
      }
    },
    
    async removeinvoice(id) {
      try {
        await api.delete(`/api/invoice/remove/${id}`)
        this.invoices = this.invoices.filter(invoice => invoice.id !== id)
        console.log(this.invoices);
        console.log(response.data.message);
      } catch (error) {
        this.error = error
        throw error
      }
    },
  },
})
