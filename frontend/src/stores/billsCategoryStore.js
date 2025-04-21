import { defineStore } from 'pinia';
import api from '../api';

export const useBillCategoryStore = defineStore('BillCategory',{
    state:()=>({
        categories:[]
    }),
    actions:{
        async fetchCategories(){
            try{
                const response = await api.get('/api/bills-category/index')
                this.categories = response.data.categories
                console.log(response.data.categories);
                console.log(response.data.message);
            }catch(error){
                console.error('Error fetching BillCategory:', error);
            }
        },
        async addCategory(categoryData){
            try{
                const response = await api.post('/api/bills-category/create',categoryData)
                console.log(response.data.category);
                console.log(response.data.message);
            }catch(error){
                console.error('Error adding category:', error);
            }
        },
        async removecategory(id){
            try{
                await api.delete(`/api/bills-category/remove/${id}`)
                this.category = this.category.filter(category => category.id !== id)
                console.log(response.data.message);
            }catch(error){
                console.error('Error removing category:', error);
            }
        },
    }
})
