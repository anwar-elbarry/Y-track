import { defineStore } from 'pinia';
import api from '../api';

export const useExpenseStore = defineStore('expense',{
    state:()=>({
        expenses:[]
    }),
    actions:{
        async fetchExpenses(){
            try{
                const response = await api.get('/api/expense/index')
                this.expenses = response.data.expenses
                console.log(response.data.expenses);
                console.log(response.data.message);
            }catch(error){
                console.error('Error fetching expenses:', error);
            }
        },
        async addExpense(expenseData){
            try{
                console.log(expenseData);
                
                const response = await api.post('/api/expense/create',expenseData)
                this.expenses.push(response.data.expense)
                console.log(response.data.expense);
                console.log(response.data.message);
            }catch(error){
                console.error('Error adding expense:', error);
            }
        },
        async removeExpense(id){
            try{
                await api.delete(`/api/expense/remove/${id}`)
                this.expenses = this.expenses.filter(expense => expense.id !== id)
                console.log(response.data.message);
            }catch(error){
                console.error('Error removing expense:', error);
            }
        },
        async updateExpense(id,expenseData){
            try{
                const response = await api.put(`/api/expense/update/${id}`,expenseData)
                const index = this.expenses.findIndex(expense => expense.id === id)
                if(index !== -1){
                    this.expenses[index] = response.data.expense
                }
                console.log(response.data.expense);
                console.log(response.data.message);
            }catch(error){
                console.error('Error updating expense:', error);
            }
        }
    }
})
