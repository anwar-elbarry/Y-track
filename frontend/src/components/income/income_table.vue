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
          <tr v-for="(item, index) in paginatedIncomes" :key="item.id"  class="border-b border-gray-200 hover:bg-gray-50">
            <td class="p-3">
              <input type="checkbox" class="rounded border-gray-300" v-model="item.selected">
            </td>
            <td class="p-3 text-left text-sm text-gray-700">#{{ incrementCounter(index) }}</td>
            <td class="p-3 text-left text-sm text-gray-700">{{ item.amount }} <span class="text-sm font-bold text-gray-600">{{ currency }}</span></td>
            <td class="p-3 text-left text-sm text-gray-700">{{ formatDate( item.created_at)}}</td>
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
              <button v-if="item.frequency !== 'one-time'" @click="updateIncomeStatus(item.status,item.id)" class="cursor-pointer px-2 py-1 text-xs rounded-full" :class="{ 'bg-green-100 text-green-800': item.status === 'active', 'bg-red-100 text-red-800': item.status === 'inactive' }">
                <span class="inline-block w-2 h-2 rounded-full mr-1" :class="{ 'bg-green-900': item.status === 'active', 'bg-red-500': item.status === 'inactive' }"></span>
                {{ item.status }}
              </button>
              <button v-if="item.frequency === 'one-time'" class="px-2 py-1 text-xs rounded-full bg-gray-100">
                NULL
              </button>
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
        <div class="flex justify-between items-center w-full">
          <div class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ startIndex + 1 }}</span>
            to
            <span class="font-medium">{{ endIndex }}</span>
            of
            <span class="font-medium">{{ totalIncomes }}</span>
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
        incomeItems: this.incomes,
        counter: 1,
        currentPage: 1,
        itemsPerPage: 5
      }
    },
    setup() {
      const incomeStore = useIncomeStore()
      return { incomeStore }
    },
    watch: {
      incomes(newIncomes) {
        this.incomeItems = newIncomes;
        this.currentPage = 1;
      }
    },
    computed: {
      totalIncomes() {
        return this.incomeItems.length;
      },
      totalPages() {
        return Math.ceil(this.totalIncomes / this.itemsPerPage);
      },
      startIndex() {
        return (this.currentPage - 1) * this.itemsPerPage;
      },
      endIndex() {
        return Math.min(this.startIndex + this.itemsPerPage, this.totalIncomes);
      },
      paginatedIncomes() {
        return this.incomeItems.slice(this.startIndex, this.endIndex);
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
          await this.incomeStore.removeIncome(id);
          this.$emit('reload-incomes');
        }catch(error){
          console.error('Error removing income:', error);
        }
      },
      sendUpdateIncome(id){
        this.$emit('selected-income',id);
      },
      async updateIncomeStatus(status, incomeId) {
        const newStatus = status === 'active' ? 'inactive' : 'active';
        
        try {
            const data = {
                status: newStatus
            };
            
            if (incomeId) {
                await this.incomeStore.updateIncome(incomeId, data);
                this.$emit('reload-incomes');
            }
        } catch (error) {
            console.error('Error updating income status:', error);
        }
      },
      incrementCounter(index) {
        return this.startIndex + index + 1;
      },
      formatDate($date){
        if (!$date) return '';
        const date = new Date($date);
        return date.toLocaleDateString('en-GB', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric'
        });
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
      }
    }
}
</script>