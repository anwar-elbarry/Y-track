<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Add New Expense
          </h2>
        
          <form @submit.prevent="validateAndSubmit" class="space-y-5">
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">name*</label>
              <div class="relative rounded-md shadow-sm">
                <input 
                  type="text" 
                  id="name" 
                  v-model="form.name" 
                  class="block w-full pl-4 pr-8 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                  placeholder="cenima ...etc"
                  :class="{'border-red-500': errors.name}"
                />
              </div>
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
            </div>
            <!-- Amount Field -->
            <div>
              <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount*</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                  <span class="text-gray-500 sm:text-sm">{{ favCurrency }}</span>
                </div>
                <input 
                  type="number" 
                  id="amount" 
                  v-model="form.amount" 
                  class="block w-full pl-4 pr-8 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                  placeholder="0.00"
                  min="0"
                  step="0.01"
                  :class="{'border-red-500': errors.amount}"
                />
              </div>
              <p v-if="errors.amount" class="mt-1 text-sm text-red-600">{{ errors.amount }}</p>
            </div>
            
            <!-- Date Field -->
            <div>
              <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date*</label>
              <input 
                type="date" 
                id="date" 
                v-model="form.date" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                :class="{'border-red-500': errors.date}"
              />
              <p v-if="errors.date" class="mt-1 text-sm text-red-600">{{ errors.date }}</p>
            </div>
            
            <!-- Category Selection -->
            <div>
              <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
              <div class="relative">
                <select 
                  id="category" 
                  v-model="form.category" 
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                  :class="{'border-red-500': errors.category}"
                >
                  <option selected value="" disabled>Select a category</option>
                  <option v-for="category in categories" :key="category" :value="category">
                    {{ category }}
                  </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <p v-if="errors.category" class="mt-1 text-sm text-red-600">{{ errors.category }}</p>
            </div>
            
            <!-- Frequency Field -->
            <div>
              <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">Frequency*</label>
              <div class="relative">
                <select 
                  id="frequency" 
                  v-model="form.frequency" 
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                  :class="{'border-red-500': errors.frequency}"
                >
                  <option selected value="One-Time">One-Time</option>
                  <option value="Weekly">Weekly</option>
                  <option value="Monthly">Monthly</option>
                  <option value="Quarterly">Quarterly</option>
                  <option value="Annually">Annually</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <p v-if="errors.frequency" class="mt-1 text-sm text-red-600">{{ errors.frequency }}</p>
            </div>
            
            <!-- Description Field -->
            <div>
              <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea 
                id="description" 
                v-model="form.description" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="Additional details about this expense"
                rows="3"
              ></textarea>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-2">
              <button 
                type="button" 
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                @click="$emit('close')"
              >
                Cancel
              </button>
              <button 
                type="submit" 
                class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200 flex items-center"
                :disabled="isSubmitting"
              >
                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Add Expense
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ExpenseForm',
    emits: ['expense-added', 'close'],
    data() {
      return {
        favCurrency : 'DH',
        isSubmitting: false,
        errors: {},
        form: {
          name: '',
          amount: '',
          currency: 'DH',
          date: new Date().toISOString().substr(0, 10),
          category: '',
          description: ''
        },
        categories: [
          'Rent',
          'Utilities',
          'Groceries',
          'Transportation',
          'Entertainment',
          'Other'
        ]
      }
    },
    computed: {
      selectedVendorDetails() {
        if (!this.form.vendor) return null;
        return this.vendors.find(v => v === this.form.vendor);
      }
    },
    methods: {
      validateAndSubmit() {
        // Reset errors
        this.errors = {};
        
        // Validate name
        if (!this.form.name || parseFloat(this.form.name) <= 0) {
          this.errors.name = 'Please enter a valid name';
        }
        // Validate amount
        if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
          this.errors.amount = 'Please enter a valid amount';
        }
        
        // Validate date
        if (!this.form.date) {
          this.errors.date = 'Please select a date';
        }
        
        // Validate category
        if (!this.form.category) {
          this.errors.category = 'Please select a category';
        }
        // Validate frequency
        if (!this.form.frequency) {
          this.errors.frequency = 'Please select a frequency';
        }
        
        // If there are errors don't submit
        if (Object.keys(this.errors).length > 0) {
          return;
        }
        
        // Show loading state
        this.isSubmitting = true;
        
        // Generate expense
        const newExpense = {
          amount: parseFloat(this.form.amount),
          currency: this.form.currency,
          date: this.formatDate(this.form.date),
          category: this.form.category,
          product: this.form.category === 'Other',
          status: this.form.status,
          frequency: this.form.frequency,
          description: this.form.description || null
        };
        
        setTimeout(() => {
          console.log('New expense entry:', newExpense);
          this.$emit('expense-added', newExpense);
          this.resetForm();
          // Hide loading state
          this.isSubmitting = false;
        }, 600);
      },
      
      resetForm() {
        this.form = {
          amount: '',
          currency: 'DH',
          date: new Date().toISOString().substr(0, 10),
          category: '',
          vendor: '',
          customVendor: '',
          status: 'Active',
          frequency: 'One-Time',
          description: ''
        };
        this.errors = {};
      },
      
      formatDate(dateString) {
        const date = new Date(dateString);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
      }
    }
  }
  </script>