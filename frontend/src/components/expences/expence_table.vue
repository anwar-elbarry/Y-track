<template>
    <div class="w-full overflow-x-auto">
      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead>
          <tr class="border-b border-gray-300 bg-gray-50">
            <th class="w-12 p-3">
              <input type="checkbox" class="rounded border-gray-300" @change="toggleSelectAll" v-model="selectAll">
            </th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Expence</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Amount</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Category</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Description</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          <tr v-for="item in expenses" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.id }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.amount }} {{ item.currency }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.date }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.category ? item.category.name : 'No Category'}}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.description }}</td>
            <td class="p-3 text-sm text-gray-700">
                <v-icon @click="removeExpense(item.id)" name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>
                <v-icon @click="sendUpdateExpense(item.id)" name="la-edit-solid" class="cursor-pointer hover:text-green-500"/>
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

  import { useExpenseStore } from '../../stores/expenseStore';
  export default {
    setup(){
      const expenseStore = useExpenseStore()
      return { expenseStore }
    },
    name : 'incomeTable',
    data() {
      return {
        selectAll: false,
        expenses: []
      }
    },
    emits : ['selected-expense','reload-expenses'],
    props : {
      expenses: {
        type: Array,
        default: () => []
      }
    },
    methods: {
      toggleSelectAll() {
        this.expenses.forEach(item => {
          item.selected = this.selectAll;
        });
      },
      sendUpdateExpense(id){
        this.$emit('selected-expense',id);
      },
      async removeExpense(id){
        try{
          await this.expenseStore.removeExpense(id);
          this.$emit('reload-expenses');
        }catch(error){
          console.log('Error to remove Expense :',error);
        }
        
      }
    }
  }
  </script>