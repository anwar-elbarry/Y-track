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
          <div class="flex gap-2">
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
              Previous
            </button>
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