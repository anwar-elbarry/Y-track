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
            <th class="p-3 text-left text-sm font-medium text-gray-500">Date</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Type</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Amount</th>
            <th class="p-3 text-left text-sm font-medium text-gray-500">Actions</th>
          </tr>
        </thead>
        
        <!-- Table Body -->
        <tbody>
          <tr v-for="item in paginatedItems" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.id }}</td>
            <td class="p-3 text-sm text-gray-700">  {{ formatDate(item.created_at)}}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.type }}</td>
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
                {{ currency }}
            
            </td>
            <td class="p-3 text-sm text-gray-700">
                <v-icon name="oi-trash" class="cursor-pointer hover:text-red-500"/>
            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="flex items-center justify-between p-4">
        <button 
          class="flex items-center px-4 py-2 text-sm border rounded text-gray-600 hover:bg-gray-50"
          @click="prevPage"
          :disabled="currentPage === 1"
          :class="{'opacity-50 cursor-not-allowed': currentPage === 1}"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Previous
        </button>
        
        <div class="flex items-center space-x-2">
          <template v-for="page in displayedPages" :key="page">
            <span 
              v-if="page !== '...'" 
              class="px-3 py-1 text-sm rounded hover:bg-gray-100 cursor-pointer"
              :class="{ 'bg-orange-100 text-orange-800': page === currentPage }"
              @click="goToPage(page)"
            >
              {{ page }}
            </span>
            <span v-else class="px-3 py-1 text-sm cursor-default">...</span>
          </template>
        </div>
        
        <button 
          class="flex items-center px-4 py-2 text-sm border rounded text-gray-600 hover:bg-gray-50"
          @click="nextPage"
          :disabled="currentPage === totalPages"
          :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}"
        >
          Next
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import {format} from 'timeago.js'
  import auth from '../../stores/auth';
  const authStore = auth();
  export default {
    name : 'transictionHistory_table',
    data() {
      return {
        selectAll: false,
        currency : authStore.user.currency,
        currentPage: 1,
        itemsPerPage: 10
        }
    },
    props : {
      transacrionItems : {
        type: Array,
        required : true
      }
    },
    computed : {
      formatDate() {
        return (date) => format(date)
      },
      totalPages() {
        return Math.ceil(this.transacrionItems.length / this.itemsPerPage);
      },
      paginatedItems() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.transacrionItems.slice(start, end);
      },
      displayedPages() {
        const pages = [];
        const totalPages = this.totalPages;
        
        if (totalPages <= 7) {
          // Less than 7 pages, show all
          for (let i = 1; i <= totalPages; i++) {
            pages.push(i);
          }
        } else {
          // Always show first page
          pages.push(1);
          
          // Show dots if current page is more than 3
          if (this.currentPage > 3) {
            pages.push('...');
          }
          
          // Show pages around current page
          const rangeStart = Math.max(2, this.currentPage - 1);
          const rangeEnd = Math.min(totalPages - 1, this.currentPage + 1);
          
          for (let i = rangeStart; i <= rangeEnd; i++) {
            pages.push(i);
          }
          
          // Show dots if current page is less than total pages - 2
          if (this.currentPage < totalPages - 2) {
            pages.push('...');
          }
          
          // Always show last page
          pages.push(totalPages);
        }
        
        return pages;
      }
    },
    methods: {
      toggleSelectAll() {
        this.transacrionItems.forEach(item => {
          item.selected = this.selectAll;
        });
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      goToPage(page) {
        this.currentPage = page;
      }
    }
    }

  </script>