import { defineStore } from 'pinia';
import api from '../api';

export const useBillStore = defineStore('bill',{
    state:()=>({
        bills:[],
        upcomingBills:[]
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
        ,
        async paybill(id){
            try{
                await api.post(`/api/upcoming-bill/${id}/pay`)
                console.log(response.data.message);
            }catch(error){
                console.error('Error paying bill:', error);
            }
        },
        async fetchUpcomingBills(){
            try{
                const response = await api.get('/api/upcoming-bill/index')
                this.upcomingBills = response.data.upcoming_bills
                console.log(response.data.upcoming_bills);
                console.log(response.data.message);
            }catch(error){
                console.error('Error fetching upcoming bills:', error);
            }
        },
        async removeUpcomingBill(id){
            try{
                await api.delete(`/api/upcoming-bill/remove/${id}`)
            }catch(error){
                console.error('Error removing upcoming bill:', error);
            }
        }
    }
})
