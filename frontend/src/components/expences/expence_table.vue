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
          <label class="text-sm text-gray-600">Amount:</label>
          <select 
            v-model="amountSort" 
            class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
          >
            <option value="">No Sort</option>
            <option value="asc">Low to High</option>
            <option value="desc">High to Low</option>
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
          <tr v-for="(item, index) in paginatedExpenses" :key="item.id" class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-sm text-gray-700">{{ incrementCounter(index) }}</td>
            <td class="p-3 text-sm text-gray-700">{{ item.amount }} <span class="text-sm font-bold text-gray-600">{{ currency }}</span></td>
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
        <div class="flex justify-between items-center w-full">
          <div class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ startIndex + 1 }}</span>
            to
            <span class="font-medium">{{ endIndex }}</span>
            of
            <span class="font-medium">{{ totalExpenses }}</span>
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
  import { useExpenseStore } from '../../stores/expenseStore';
  import auth from '../../stores/auth';
  const useAuthStore = auth();
  export default {
    setup(){
      const expenseStore = useExpenseStore()
      return { expenseStore }
    },
    name : 'incomeTable',
    props : {
      expenses: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        selectAll: false,
        currency: useAuthStore.user.currency,
        expenseItems: this.expenses,
        currentPage: 1,
        itemsPerPage: 5,
        selectedCategory: '',
        amountSort: ''
      }
    },
    watch: {
      expenses(newExpenses) {
        this.expenseItems = newExpenses;
        this.currentPage = 1;
      },
      selectedCategory() {
        this.currentPage = 1;
      },
      amountSort() {
        this.currentPage = 1;
      }
    },
    computed: {
      uniqueCategories() {
        return [...new Set(this.expenseItems.map(item => 
            item.category ? item.category.name : 'Uncategorized'
        ))];
      },
      filteredAndSortedExpenses() {
        let filtered = this.expenseItems.filter(item => {
          const categoryName = item.category ? item.category.name : 'Uncategorized';
          return !this.selectedCategory || categoryName === this.selectedCategory;
        });

        if (this.amountSort) {
          filtered.sort((a, b) => {
            const amountA = parseFloat(a.amount);
            const amountB = parseFloat(b.amount);
            return this.amountSort === 'asc' ? amountA - amountB : amountB - amountA;
          });
        }

        return filtered;
      },
      totalExpenses() {
        return this.filteredAndSortedExpenses.length;
      },
      totalPages() {
        return Math.ceil(this.totalExpenses / this.itemsPerPage);
      },
      startIndex() {
        return (this.currentPage - 1) * this.itemsPerPage;
      },
      endIndex() {
        return Math.min(this.startIndex + this.itemsPerPage, this.totalExpenses);
      },
      paginatedExpenses() {
        return this.filteredAndSortedExpenses.slice(this.startIndex, this.endIndex);
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
        this.expenseItems.forEach(item => {
          item.selected = this.selectAll;
        });
      },
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
      goToPage(page) {
        this.currentPage = page;
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
        
      },
      clearFilters() {
        this.selectedCategory = '';
        this.amountSort = '';
        this.currentPage = 1;
      }
    }
  }
  </script>