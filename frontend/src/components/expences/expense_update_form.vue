<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Update Expense
          </h2>
        
          <form @submit.prevent="validateAndSubmit" class="space-y-5">
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
                  v-model="form.category_id" 
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                  :class="{'border-red-500': errors.category}"
                >
                  <option selected value="" disabled>Select a category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
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
                Update Expense
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  

  <script>
  import { useExpenseStore } from '../../stores/expenseStore';
  import auth from '../../stores/auth';
  const useAuthStore = auth();
  export default {
    name: 'ExpenseUpdateForm',
    emits: ['expense-updated', 'close'],
    setup(){
      const expenseStore = useExpenseStore()
      return { expenseStore }
    },
    props : {
        categories :{
            type : Array,
            default : () => []
        },
        expenseToUpdate : {
            type : Object,
            required : true
        }
    },
    data() {
      return {
        favCurrency : useAuthStore.user.currency,
        isSubmitting: false,
        errors: {},
        form: {
          amount: '',
          date: new Date().toISOString().substr(0, 10),
          category_id:'',
          description: ''
        },
  
      }
    },
    methods: {
    async  validateAndSubmit() {
        this.errors = {};
        
        // Validate amount
        if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
          this.errors.amount = 'Please enter a valid amount';
        }
        
        // Validate date
        if (!this.form.date) {
          this.errors.date = 'Please select a date';
        }
        
        // Validate category
        if (!this.form.category_id) {
          this.errors.category_id = 'Please select a category';
        }

        if (Object.keys(this.errors).length > 0) {
          return;
        }
        
        try {
            this.isSubmitting = true;
            await this.expenseStore.updateExpense(this.expenseToUpdate.id, {
                amount: parseFloat(this.form.amount),
                date: this.form.date,
                category_id: this.form.category_id,
                description: this.form.description || ''
            });
            
            await this.$emit('expense-updated'); 
            this.$emit('close');
        } catch(error) {
            console.error('Error updating expense:', error);
            this.errors.submit = 'Failed to update expense';
        } finally {
            this.isSubmitting = false;
        }
      },
      initializeForm(){
        this.form.amount = this.expenseToUpdate.amount,
        this.form.category_id = this.expenseToUpdate.category_id,
        this.form.date = this.expenseToUpdate.date,
        this.form.description = this.expenseToUpdate.description
      },
      resetForm() {
        this.form = {
          amount: '',
          date: new Date().toISOString().substr(0, 10),
          category_id: '',
          description: ''
        };
        this.errors = {};
      },
    },
    created(){
        this.initializeForm();
    }
  }
  </script>