<template>
    <div class="w-full overflow-x-auto">
      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead>
          <tr class="border-b border-gray-300 bg-gray-50">
            <th class="w-12 p-3">
              <input type="checkbox" class="rounded border-gray-300" @change="toggleSelectAll" v-model="selectAll">
            </th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Income</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Amount</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Source</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Status</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Frequency</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
         
        <tbody>
          <tr v-for="item in incomeItems" :key="item.id"  class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-left text-sm text-gray-700">#{{ item.id }}</td>
            <td class="p-3 text-left text-sm text-gray-700">{{ item.amount }} <span class="text-sm font-bold text-gray-600">{{ currency }}</span></td>
            <td class="p-3 text-left text-sm text-gray-700">{{ item.date }}</td>
            <td class="p-3 text-left text-sm">
              <div class="flex items-center space-x-3">
                <!-- Client Avatar and Info -->
                <div v-if="item.client" class="flex items-center space-x-3">
                  <div class="relative">
                    <img 
                      :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(item.client.name)}&background=random&color=fff&size=128`"
                      class="w-10 h-10 rounded-full border-2 border-gray-200 object-cover"
                      :alt="item.client.name"
                    />
                  </div>
                  <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900">{{ item.client.name }}</span>
                    <span class="text-xs text-gray-500">{{ item.client.email }}</span>
                  </div>
                </div>
                
                <!-- Other Source Display -->
                <div v-else class="flex items-center">
                  <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900">{{ item.source }}</span>
                    <span class="text-xs text-gray-500">Other Source</span>
                  </div>
                </div>
              </div>
            </td>
            <td class="text-left p-3">
              <span class="px-2 py-1 text-xs rounded-full" :class="{ 'bg-green-100 text-green-800': item.status === 'active', 'bg-red-100 text-red-800': item.status === 'inactive' }">
                <span class="inline-block w-2 h-2 rounded-full mr-1" :class="{ 'bg-green-900': item.status === 'active', 'bg-red-500': item.status === 'inactive' }"></span>
                {{ item.status }}
              </span>
            </td>
            <td class="p-3 text-left text-sm text-gray-700">{{ item.frequency }}</td>
            <td class="p-3 text-left text-sm text-gray-700">
                <v-icon @click="removeIncome(item.id)" name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>
                <v-icon @click="sendUpdateIncome(item.id)" name="la-edit-solid" class="cursor-pointer hover:text-green-500"/>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="flex items-center justify-between p-4">
        <button class="flex items-center px-4 py-2 text-sm border rounded text-gray-600 hover:bg-gray-50">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Previous
        </button>
        
        <div class="flex items-center space-x-2">
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer bg-orange-100 text-orange-800">1</span>
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer">2</span>
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer">3</span>
          <span class="px-3 py-1 text-sm cursor-default">...</span>
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer">8</span>
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer">9</span>
          <span class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer">10</span>
        </div>
        
        <button class="inline-block">Next</button>
      </div>
    </div>
  </template>
  
  <script>
import { useIncomeStore } from '../../stores/incomeStore';
import auth from '../../stores/auth';
const useAuthStore = auth();
export default {
    name : 'incomeTable',
    props: {
      incomes: {
        type: Array,
        default: () => []
      }
    },
    emits : ['reload-incomes','selected-income'],
    data() {
      return {
        selectAll: false,
        currency: useAuthStore.user.currency,
        incomeItems: this.incomes
      }
    },
    setup() {
      const incomeStore = useIncomeStore()
      return { incomeStore }
    },
    watch: {
      incomes(newIncomes) {
        this.incomeItems = newIncomes;
      }
    },
    methods: {
      toggleSelectAll() {
        this.incomeItems.forEach(item => {
          item.selected = this.selectAll;
        });
      },
      async removeIncome(id){
        try{
          await this.incomeStore.removeIncome(id)
          this.$emit('reload-incomes');
        }catch(error){
          console.error('Error removing income:', error);
        }
      },
      sendUpdateIncome(id){
        this.$emit('selected-income',id);
      }
    }
}
</script>