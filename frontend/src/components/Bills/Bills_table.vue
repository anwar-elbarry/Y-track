<template>
    <div class="w-full overflow-x-auto">
      <!-- Filters -->
      <div class="bg-white p-4 mb-4 flex gap-4 items-center">
        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">Category:</label>
          <select 
            v-model="selectedCategory" 
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
          >
            <option value="">All Categories</option>
            <option v-for="category in uniqueCategories" :key="category" :value="category">
              {{ category }}
            </option>
          </select>
        </div>

        <div class="flex items-center gap-2">
          <label class="text-sm text-gray-600">Frequency:</label>
          <select 
            v-model="selectedFrequency" 
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
          >
            <option value="">All Frequencies</option>
            <option value="one-time">One Time</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
          </select>
        </div>

        <button 
          @click="clearFilters"
          class="text-sm text-gray-600 hover:text-orange-500 flex items-center gap-1"
        >
          Clear Filters
        </button>
      </div>

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
          <tr v-for="(item, index) in paginatedBills" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ incrementCounter(index) }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.amount }} <span class="text-sm font-bold text-gray-600">{{ currency }}</span></td>
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
              <span class="px-2 py-1 border border-gray-500 text-xs rounded-full bg-white" :class="{ ' text-green-800': item.status === 'Paid', ' text-red-800': item.status === 'unpaid', ' text-orange-800': item.status === 'pending' }">
                <span class="inline-block w-2 h-2 rounded-full mr-1" :class="{ 'bg-green-500': item.status === 'paid', 'bg-red-500': item.status === 'unpaid', 'bg-orange-500': item.status === 'pending' }"></span>
                {{ item.status }}
              </span>
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.category.name }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.frequency }}</td>
            <td class="p-3 text-sm text-gray-700">
                <v-icon @click="removeBill(item.id)" name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>

            </td>
          </tr>
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="flex items-center justify-between p-4">
        <div class="flex justify-between items-center w-full">
          <div class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ startIndex + 1 }}</span>
            to
            <span class="font-medium">{{ endIndex }}</span>
            of
            <span class="font-medium">{{ totalBills }}</span>
            results
          </div>
          <div class="flex items-center space-x-2">
            <button 
              @click="previousPage" 
              :disabled="currentPage === 1"
              :class="[
                'relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md',
                currentPage === 1 
                  ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                  : 'bg-white text-gray-700 hover:bg-gray-50'
              ]"
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
              @click="nextPage"
              :disabled="currentPage >= totalPages"
              :class="[
                'relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md',
                currentPage >= totalPages 
                  ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                  : 'bg-white text-gray-700 hover:bg-gray-50'
              ]"
            >
              Next
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Swal from 'sweetalert2'
  import auth from '../../stores/auth';
  import { useBillStore } from '../../stores/billsStore';
  const useAuthStore = auth();
  export default {
    
    name : 'BillTable',
    data() {
      return {
        selectAll: false,
        currency: useAuthStore.user.currency,
        BillItems: this.bills,
        currentPage: 1,
        itemsPerPage: 5,
        selectedCategory: '',
        selectedFrequency: ''
      }
    },
    watch: {
      bills(newBills) {
        this.BillItems = newBills;
        this.currentPage = 1;
      },
      selectedCategory() {
        this.currentPage = 1;
      },
      selectedFrequency() {
        this.currentPage = 1;
      }
    },
    props : {
      bills: {
        type : Array,
        default : ()=> []
      }
    },
    emits : ['removed-bill'],
    setup(){
      const billStore = useBillStore();
      return {billStore}
    },
    computed: {
      uniqueCategories() {
        return [...new Set(this.BillItems.map(item => 
          item.category ? item.category.name : 'Uncategorized'
        ))];
      },
      filteredBills() {
        return this.BillItems.filter(item => {
          const categoryName = item.category ? item.category.name : 'Uncategorized';
          const categoryMatch = !this.selectedCategory || categoryName === this.selectedCategory;
          const frequencyMatch = !this.selectedFrequency || item.frequency === this.selectedFrequency;
          return categoryMatch && frequencyMatch;
        });
      },
      totalBills() {
        return this.filteredBills.length;
      },
      totalPages() {
        return Math.ceil(this.totalBills / this.itemsPerPage);
      },
      startIndex() {
        return (this.currentPage - 1) * this.itemsPerPage;
      },
      endIndex() {
        return Math.min(this.startIndex + this.itemsPerPage, this.totalBills);
      },
      paginatedBills() {
        return this.filteredBills.slice(this.startIndex, this.endIndex);
      },
      displayedPages() {
        const pages = [];
        const totalPages = this.totalPages;
        
        if (totalPages <= 7) {
          for (let i = 1; i <= totalPages; i++) {
            pages.push(i);
          }
        } else {

          pages.push(1);
          
          if (this.currentPage > 3) {
            pages.push('...');
          }
          
          const rangeStart = Math.max(2, this.currentPage - 1);
          const rangeEnd = Math.min(totalPages - 1, this.currentPage + 1);
          
          for (let i = rangeStart; i <= rangeEnd; i++) {
            pages.push(i);
          }
          
          if (this.currentPage < totalPages - 2) {
            pages.push('...');
          }
          
          pages.push(totalPages);
        }
        
        return pages;
      }
    },
    methods: {
      incrementCounter(index) {
        return this.startIndex + index + 1;
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      previousPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
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
      },
      
      // remove bill
      removeBill(id) {
        Swal.fire({
        title: 'Delete Bill?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
      }).then((result) => {
        if (result.isConfirmed) {
          this.$emit('removed-bill',id);

           this.$notify({
            title: 'Deleted!',
            text: 'Item was successfully deleted.',
            type: 'success',
          })
        }
      });

      },
      clearFilters() {
        this.selectedCategory = '';
        this.selectedFrequency = '';
        this.currentPage = 1;
      },
      goToPage(page) {
        this.currentPage = page;
      }
    }
  }
  </script>