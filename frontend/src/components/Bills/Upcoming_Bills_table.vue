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
            <td class="p-3 text-sm text-gray-700">{{ item.original_bill.amount }} <span class="text-sm font-bold text-gray-600">{{ currency }}</span></td>
            <td class="p-3 text-sm text-gray-700">{{ item.due_date }}</td>
            <td class="p-3 text-sm">
              <div class="flex items-center">
                <div v-if="item.original_bill.image" class="w-8 h-8 rounded-full mr-2">
                  <img :src="item.original_bill.image" class="w-full h-full rounded-full" alt="Profile">
                </div>
                <div v-else class="w-8 h-8 rounded-full bg-gray-200 mr-2 flex items-center justify-center">
                    <img :src="`https://ui-avatars.com/api/?name=${ item.original_bill.name }&background=random&color=fff&size=128`" class="w-full h-full rounded-full" alt="Profile">
                </div>
                <div>
                  <div class="text-gray-700">{{ item.original_bill.name }}</div>
                </div>
              </div>
            </td>
            <td class="p-3">
              <span class="px-2 py-1 border border-gray-500 text-xs rounded-full bg-white" :class="{ 'text-green-800': item.status === 'paid', 'text-red-800': item.status === 'unpaid', 'text-orange-800': item.status === 'pending' }">
                <span class="inline-block w-2 h-2 rounded-full mr-1" :class="{ 'bg-green-500': item.status === 'paid', 'bg-red-500': item.status === 'unpaid', 'bg-orange-500': item.status === 'pending' }"></span>
                {{ item.status }}
              </span>
            </td>
            <td class="p-3 text-sm text-gray-700">{{ item.original_bill.frequency }}</td>
            <td class="p-3 text-sm text-gray-700">
                <v-icon @click="removeBill(item.id)" name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>
                <button 
                  v-if="item.status === 'unpaid'" 
                  @click="payBill(item.id)" 
                  class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition-colors"
                >
                  Pay
                </button>
                <span 
                  v-else 
                  class="px-2 py-1 bg-gray-200 text-green-800 text-xs rounded"
                >
                  Paid
                </span>
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
  import auth from '../../stores/auth';
  import { useBillStore } from '../../stores/billsStore';
  const useAuthStore = auth();
  export default {
    
    name : 'UpcomingBillTable',
    props : {
        upcomingBillItems: {
        type : Array,
        default : ()=> []
      }
    },
    data() {
      return {
        selectAll: false,
        currency: useAuthStore.user.currency,
        billItems: this.upcomingBillItems,
        currentPage: 1,
        itemsPerPage: 5
      }
    },
    emits : ['removed-upcoming-bill','paid-upcoming-bill'],
    setup(){
      const billStore = useBillStore();
      return {billStore}
    },
    watch: {
        upcomingBillItems(newBills) {
            this.billItems = newBills;
            this.currentPage = 1;
        }
    },
    computed: {
        totalBills() {
            return this.billItems.length;
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
            return this.billItems.slice(this.startIndex, this.endIndex);
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
            this.billItems.forEach(item => {
                item.selected = this.selectAll;
            });
        },
        removeBill(id) {
            this.$emit('removed-upcoming-bill',id);
        },
        payBill(id) {
           this.$emit('paid-upcoming-bill',id);
        }
    }
  }
  </script>