import { defineStore } from 'pinia';
import api from '../api';

export const useBillStore = defineStore('bill',{
    state:()=>({
        bills:[]
    }),
    actions:{
        async fetchBills(){
            try{
                const response = await api.get('/api/bill/index')
                this.bills = response.data.bills
                console.log(response.data.bills);
                console.log(response.data.message);
            }catch(error){
                console.error('Error fetching bills:', error);
            }
        },
        async addbill(billData){
            try{
                console.log(billData);
                
                const response = await api.post('/api/bill/create',billData)
                this.bills.push(response.data.bill)
                console.log(response.data.bill);
                console.log(response.data.message);
            }catch(error){
                console.error('Error adding bill:', error);
            }
        },
        async removebill(id){
            try{
                await api.delete(`/api/bill/remove/${id}`)
                this.bills = this.bills.filter(bill => bill.id !== id)
                console.log(response.data.message);
            }catch(error){
                console.error('Error removing bill:', error);
            }
        },
        async updatebill(id,billData){
            try{
                const response = await api.put(`/api/bill/update/${id}`,billData)
                const index = this.bills.findIndex(bill => bill.id === id)
                if(index !== -1){
                    this.bills[index] = response.data.bill
                }
                console.log(response.data.bill);
                console.log(response.data.message);
            }catch(error){
                console.error('Error updating bill:', error);
            }
        }
    }
})
