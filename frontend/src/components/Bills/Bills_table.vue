<template>
    <div class="w-full overflow-x-auto">
      <table class="min-w-full bg-white">
        <!-- Table Header -->
        <thead>
          <tr class="border-b border-gray-300 bg-gray-50">
            <th class="w-12 p-3">
              <input type="checkbox" class="rounded border-gray-300" @change="toggleSelectAll" v-model="selectAll">
            </th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Bill</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Amount</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Due Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Name</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Status</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Category</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Frequency</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          <tr v-for="item in BillItems" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.id }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.amount }} {{ item.currency }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.due_date }}</td>
            <td class="p-3 text-sm">
              <div class="flex items-center">
                <img  v-if="item.image" :src="item.image" class="w-8 h-8 rounded-full mr-2" alt="Profile">
                <div v-else class="w-8 h-8 rounded-full bg-gray-200 mr-2 flex items-center justify-center">
                  <span class="text-gray-600 font-bold">{{ getInitials(item.name) }}</span>
                </div>
                <div>
                  <div class="text-gray-700">{{ item.name }}</div>
                </div>
              </div>
            </td>
            <td class="p-3">
              <span class="px-2 py-1 border border-gray-500 text-xs rounded-full bg-white" :class="{ ' text-green-800': item.status === 'Paid', ' text-red-800': item.status === 'unpaid' }">
                <span class="inline-block w-2 h-2 rounded-full mr-1" :class="{ 'bg-green-500': item.status === 'Paid', 'bg-red-500': item.status === 'unpaid' }"></span>
                {{ item.status }}
              </span>
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.category }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.frequency }}</td>
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
    
    name : 'BillTable',
    data() {
      return {
        selectAll: false,
        BillItems: [
          {
            id: '#3066',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 6, 2025',
            name: 'Olivia Rhye',
            status: 'unpaid',
            category: 'internet',
            frequency: 'Monthly',
            selected: false
          },
          {
            id: '#3065',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 6, 2025',
            image: '/Y-track/frontend/src/assets/bills_icons/Google_Ads.png',
            name: 'Digital Product Sales',
            status: 'Paid',
            category: 'internet',
            frequency: 'One-Time',
            selected: false
          },
          {
            id: '#3064',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 6, 2025',
            name: 'Lana Steiner',
            email: 'lana@untitledui.com',
            status: 'Paid',
            category: 'internet',
            frequency: 'Monthly',
            selected: false
          },
          {
            id: '#3063',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 5, 2025',
            name: 'Demi Wilkinson',
            status: 'Paid',
            category: 'internet',
            frequency: 'Annually',
            selected: false
          },
          {
            id: '#3062',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 5, 2025',
            name: 'Candice Wu',
            status: 'Paid',
            category: 'internet',
            frequency: 'Weekly',
            selected: false
          },
          {
            id: '#3061',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 5, 2025',
            name: 'Natali Craig',
            status: 'Paid',
            category: 'internet',
            frequency: 'Weekly',
            selected: false
          },
          {
            id: '#3060',
            amount: 2000,
            currency: 'DH',
            due_date: 'Jan 4, 2025',
            name: 'Drew Cano',
            status: 'Paid',
            category: 'internet',
            frequency: 'Weekly',
            selected: false
          }
        ]
      }
    },
    methods: {
      toggleSelectAll() {
        this.BillItems.forEach(item => {
          item.selected = this.selectAll;
        });
      },
      getInitials(name) {
        if (!name) return '';
        return name
          .split(' ')
          .map(word => word[0])
          .join('')
          .toUpperCase()
          .substring(0, 2);
      }
    }
  }
  </script>