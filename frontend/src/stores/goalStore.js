import { defineStore } from 'pinia';
import api from '../api';

export const useGoalStore = defineStore('goal',{
    state:()=>({
        goals:[],
        message : ''
    }),
    actions:{
        async fetchgoals(){
            try{
                const response = await api.get('/api/goal/index')
                this.goals = response.data.goals
                console.log(response.data.goals);
                console.log(response.data.message);
            }catch(error){
                console.error('Error fetching goals:', error);
            }
        },
        async addgoal(goalData){
            try{
                console.log(goalData);
                
                const response = await api.post('/api/goal/create',goalData)
                this.goals.push(response.data.goal)
                console.log(response.data.goal);
                console.log(response.data.message);
            }catch(error){
                console.error('Error adding goal:', error);
            }
        },
        async removegoal(id){
            try{
                await api.delete(`/api/goal/remove/${id}`)
                this.goals = this.goals.filter(goal => goal.id !== id)
                console.log(response.data.message);
            }catch(error){
                console.error('Error removing goal:', error);
            }
        },
        async updategoal(id,goalData){
            try{
                const response = await api.put(`/api/goal/update/${id}`,goalData)
                const index = this.goals.findIndex(goal => goal.id === id)
                if(index !== -1){
                    this.goals[index] = response.data.goal
                }
                console.log(response.data.goal);
                console.log(response.data.message);
                this.message = response.data.message;
            }catch(error){
                console.error('Error updating goal:', error);
            }
        }
    }
})
