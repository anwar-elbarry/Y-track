<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Update Income
          </h2>
        
          <form @submit.prevent="validateAndSubmit" class="space-y-5">
            <!-- Amount  -->
            <div>
              <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
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
            
            <!-- start_at  -->
            <div>
              <label for="date" class="block text-sm font-medium text-gray-700 mb-1">start_at*</label>
              <input 
                type="date" 
                id="start_at" 
                v-model="form.start_at" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                :class="{'border-red-500': errors.start_at}"
              />
              <p v-if="errors.start_at" class="mt-1 text-sm text-red-600">{{ errors.start_at }}</p>
            </div>
            
            
            <!-- Frequency -->
            <div>
              <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">Frequency*</label>
              <div class="relative">
                <select 
                  id="frequency" 
                  v-model="form.frequency" 
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                  :class="{'border-red-500': errors.frequency}"
                >
                  <option value="one-time">One-Time</option>
                  <option value="daily">Daily</option>
                  <option value="weekly">Weekly</option>
                  <option value="monthly">Monthly</option>
                  <option value="yearly">Yearly</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <p v-if="errors.frequency" class="mt-1 text-sm text-red-600">{{ errors.frequency }}</p>
            </div>
            <div>
</div>
            <!-- Form  -->
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
              >
                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Update Income
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import auth from '../../stores/auth';
  import {useIncomeStore} from '../../stores/incomeStore';
  const useAuthStore = auth();
  export default {
    name: 'IncomeFormUpdate',
    props: {
      incomeToUpdate: {
        type: Object,
        required: true
      }
    },
    setup() {
      const incomeStore = useIncomeStore()
      return { incomeStore}
    },
    emits: ['income-updated', 'close'],
    data() {
      return {
        favCurrency: useAuthStore.user.currency,
        isSubmitting: false,
        errors: {},
        form: {
          amount: '',
          start_at: '',
          frequency: '',
        },
      }
    },
    created() {
      this.initializeForm();
    },
    methods: {
      initializeForm() {
        this.form.amount = this.incomeToUpdate.amount.toString();
        this.form.start_at = this.incomeToUpdate.start_at;
        this.form.frequency = this.incomeToUpdate.frequency;
      },
      async validateAndSubmit() {
        this.errors = {};
        
        if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
          this.errors.amount = 'Please enter a valid amount';
        }

        if (!this.form.start_at) {
          this.errors.start_at = 'Please select a start_at';
        }
        
        if (!this.form.frequency) {
          this.errors.frequency = 'Please select a frequency';
        }
        
        if (Object.keys(this.errors).length > 0) {
          return;
        }
        
        const updatedIncome = {
          id: this.incomeToUpdate.id,
          amount: this.form.amount,
          start_at: this.form.start_at,
          frequency: this.form.frequency,
        };
      
        try {
          this.isSubmitting = true;
          const response = await this.incomeStore.updateIncome(this.incomeToUpdate.id, updatedIncome);
          
          this.$emit('income-updated');
          this.$emit('close');
        } catch(error) {
          console.error('Error updating income', error);
          this.errors.submit = 'Failed to update income. Please try again.';
        } finally {
          this.isSubmitting = false;
        }
      },
      
      resetForm() {
        this.initializeForm();
        this.errors = {};
      }
    }
  }
  </script>