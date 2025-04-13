<template>
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Tax Records</h1>
    
    <!-- Search and Filter Bar -->
    <div class="flex gap-3 mb-6">
      <div class="relative flex-grow">
        <input
          type="text"
          placeholder="Search taxes..."
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="searchQuery"
        />
      </div>
      <div class="relative">
        <button
          class="px-4 py-2 bg-white border border-gray-300 rounded-md flex items-center gap-2 hover:bg-gray-50"
          @click="toggleSortOptions"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          Sort By
        </button>
        <div v-if="showSortOptions" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
          <div class="py-1">
            <button @click="sortBy('dueDate')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
              Due Date
            </button>
            <button @click="sortBy('amount')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
              Amount
            </button>
            <button @click="sortBy('status')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
              Status
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Tax Records Table -->
    <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tax Type
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Amount
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Due Date
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(tax, index) in filteredTaxes" :key="index">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">{{ tax.type }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">${{ tax.amount.toLocaleString() }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">{{ formatDate(tax.dueDate) }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span 
                :class="{
                  'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full': true,
                  'bg-green-100 text-green-800': tax.status === 'Paid',
                  'bg-red-100 text-red-800': tax.status === 'Overdue',
                  'bg-yellow-100 text-yellow-800': tax.status === 'Upcoming'
                }"
              >
                {{ tax.status }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
              <button class="text-sm bg-white hover:bg-gray-50 text-gray-700 font-semibold py-1 px-3 border border-gray-300 rounded shadow-sm">
                View
              </button>
              <button 
                v-if="tax.status !== 'Paid'" 
                class="text-sm bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 border border-blue-600 rounded shadow-sm"
              >
                Pay
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <!-- Upload Tax Payment Proof Section -->
    <div class="mt-8 bg-white border border-gray-200 rounded-md p-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-1">Upload Tax Payment Proof</h2>
      <p class="text-sm text-gray-500 mb-6">Upload receipts or confirmation of your tax payments</p>
      
      <div class="space-y-4">
        <div>
          <label for="payment-proof" class="block text-sm font-medium text-gray-700 mb-1">Payment Proof</label>
          <div class="flex">
            <label for="file-upload" class="cursor-pointer bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
              Choose File
              <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleFileChange" />
            </label>
            <span class="ml-3 py-2 text-sm text-gray-500">{{ fileName || 'No file chosen' }}</span>
          </div>
        </div>
        
        <div>
          <label for="tax-type" class="block text-sm font-medium text-gray-700 mb-1">Tax Type</label>
          <select
            id="tax-type"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
            v-model="selectedTaxType"
          >
            <option value="" disabled selected>Select tax type</option>
            <option>Income Tax</option>
            <option>Property Tax</option>
            <option>Sales Tax</option>
            <option>Business Tax</option>
          </select>
        </div>
        
        <div class="flex justify-end">
          <button
            type="button"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-black hover:bg-gray-800 focus:outline-none"
            @click="uploadFile"
          >
            Upload
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaxRecords',
  data() {
    return {
      searchQuery: '',
      showSortOptions: false,
      sortKey: null,
      sortDirection: 'asc',
      fileName: '',
      selectedTaxType: '',
      taxes: [
        { type: 'Income Tax', amount: 5200, dueDate: new Date('2023-04-15'), status: 'Paid' },
        { type: 'Income Tax', amount: 5200, dueDate: new Date('2023-04-15'), status: 'Overdue' },
        { type: 'Income Tax', amount: 5200, dueDate: new Date('2023-04-15'), status: 'Upcoming' },
        { type: 'Income Tax', amount: 5200, dueDate: new Date('2023-04-15'), status: 'Upcoming' },
        { type: 'Income Tax', amount: 5200, dueDate: new Date('2023-04-15'), status: 'Paid' },
      ]
    }
  },
  computed: {
    filteredTaxes() {
      let result = [...this.taxes];
      
      // Apply search filter
      if (this.searchQuery) {
        const query = this.searchQuery.toLowerCase();
        result = result.filter(tax => 
          tax.type.toLowerCase().includes(query) || 
          tax.status.toLowerCase().includes(query)
        );
      }
      
      // Apply sorting
      if (this.sortKey) {
        result.sort((a, b) => {
          let comparison = 0;
          if (a[this.sortKey] < b[this.sortKey]) {
            comparison = -1;
          } else if (a[this.sortKey] > b[this.sortKey]) {
            comparison = 1;
          }
          return this.sortDirection === 'desc' ? comparison * -1 : comparison;
        });
      }
      
      return result;
    }
  },
  methods: {
    toggleSortOptions() {
      this.showSortOptions = !this.showSortOptions;
    },
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortKey = key;
        this.sortDirection = 'asc';
      }
      this.showSortOptions = false;
    },
    formatDate(date) {
      return date.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      this.fileName = file ? file.name : '';
    },
    uploadFile() {
      if (!this.fileName || !this.selectedTaxType) {
        alert('Please select a file and tax type before uploading');
        return;
      }
      
      // Here you would typically implement actual file upload logic
      alert(`File "${this.fileName}" uploaded for ${this.selectedTaxType}`);
      
      // Reset form
      this.fileName = '';
      this.selectedTaxType = '';
      document.getElementById('file-upload').value = '';
    }
  }
}
</script>