<template>
    <div class="w-full overflow-x-auto">
      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead>
          <tr class="border-b border-gray-300 bg-gray-50">
            <th class="w-12 p-3">
              <input type="checkbox" class="rounded border-gray-300" @change="toggleSelectAll" v-model="selectAll">
            </th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">id</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">name</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Type</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Category/Source</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Amount</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          <tr v-for="item in transacrionItems" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.id }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.name }} {{ item.currency }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.date }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.type }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.category }}</td>
            <td class="p-3 text-sm "
                :class="{'text-green-500' : item.type == 'income' , 'text-red-500' : item.type != 'income'}"        
            >
            <span v-if="item.type !== 'income'">
                -
            </span>    
            <span v-else>
                +    
            </span>    
                {{ item.amount }}
                {{ item.currency }}
            
            </td>
            <td class="p-3 text-sm text-gray-700">
                <v-icon name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>
                <v-icon name="la-edit-solid" class="cursor-pointer hover:text-green-500"/>
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
  export default {
    name : 'transictionHistory_table',
    data() {
      return {
        selectAll: false,
        transacrionItems: [
          {
            id: '#3066',
            name: 2000,
            currency: 'DH',
            date: 'Jan 6, 2025',
            category: 'Olivia Rhye',
            type: 'expence',
            amount: 3999,
            selected: false
          },
          {
            id: '#3065',
            name: 2000,
            currency: 'DH',
            date: 'Jan 6, 2025',
            category: 'Digital Product Sales',
            type: 'tax',
            amount: 3999,
            selected: false
          },
          {
            id: '#3064',
            name: 2000,
            currency: 'DH',
            date: 'Jan 6, 2025',
            category: 'Lana Steiner',
            type: 'income',
            amount: 3999,
            selected: false
          },
          {
            id: '#3063',
            name: 2000,
            currency: 'DH',
            date: 'Jan 5, 2025',
            category: 'Demi Wilkinson',
            type: 'income',
            amount: 3999,
            selected: false
          },
          {
            id: '#3062',
            name: 2000,
            currency: 'DH',
            date: 'Jan 5, 2025',
            category: 'Candice Wu',
            type: 'expence',
            amount: 3999,
            selected: false
          },
          {
            id: '#3061',
            name: 'freelince',
            currency: 'DH',
            date: 'Jan 5, 2025',
            category: 'Natali Craig',
            type: 'bill',
            amount: 3999,
            selected: false
          },
          {
            id: '#3060',
            name: 2000,
            currency: 'DH',
            date: 'Jan 4, 2025',
            category: 'Drew Cano',
            type: 'bill',
            amount: 3999,
            selected: false
          }
        ]
      }
    }
  }
  </script>