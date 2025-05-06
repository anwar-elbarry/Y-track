<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Add New Bill
          </h2>
        
          <form @submit.prevent="validateAndSubmit" class="space-y-5">
            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Bill Name*</label>
              <input 
                type="text" 
                id="name" 
                v-model="form.name" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="Internet, Rent, Electricity, etc."
                :class="{'border-red-500': errors.name}"
              />
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
            
            <!-- Bills Category Selection -->
            <div>
              <label for="bills_category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
              <div class="relative">
                <select 
                  id="bills_category" 
                  v-model="form.bills_category" 
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                  :class="{'border-red-500': errors.bills_category}"
                >
                  <option selected value="" disabled>Select a category</option>
                  <option v-for="category in billsCategories" :key="category.id" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <p v-if="errors.bills_category" class="mt-1 text-sm text-red-600">{{ errors.bills_category }}</p>
            </div>
            
            <!-- Frequency Selection -->
            <div>
              <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">Payment Frequency*</label>
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
                  <option value="quarterly">Quarterly</option>
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
            
            <!-- Due Date Field -->
            <div>
              <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date*</label>
              <input 
                type="date" 
                id="due_date" 
                v-model="form.due_date" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                :class="{'border-red-500': errors.due_date}"
              />
              <p v-if="errors.due_date" class="mt-1 text-sm text-red-600">{{ errors.due_date }}</p>
            </div>
            
            <!-- Logo Field -->
            <div>
              <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo (Optional)</label>
              <div class="flex items-center space-x-4">
                <div 
                  class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300"
                  v-if="logoPreview"
                >
                  <img :src="logoPreview" alt="Bill logo" class="w-full h-full object-cover" />
                </div>
                <div 
                  v-else
                  class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center border border-gray-300"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="flex-1">
                  <input 
                    type="file" 
                    id="logo" 
                    ref="logoInput"                    @change="handleLogoUpload" 
                    class="hidden"
                    accept="image/jpeg,image/
png,image/jpg,image/gif,image/svg+xml"
                  />
                  <button
                    type="button"
                    @click="$refs.logoInput.click()"
                    class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
                  >
                    {{ logoPreview ? 'Change' : 'Upload' }} Logo
                  </button>
                  <p v-if="form.logo" class="mt-1 text-xs text-gray-500">{{ getFileName(form.logo) }}</p>
                </div>
              </div>
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
                Add Bill
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import {useBillStore} from '../../stores/billsStore'
  import auth from '../../stores/auth';
  const useAuthStore = auth();
  
  export default {
    name: 'BillForm',
    emits: ['bill-added', 'close'],
    setup() {
      const billStore = useBillStore();
      return { billStore };
    },
    props: {
      billsCategories: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        favCurrency: useAuthStore.user.currency,
        isSubmitting: false,
        errors: {},
        logoPreview: null,
        form: {
          name: '',
          amount: '',
          bills_category: '',
          frequency: '',
          due_date: new Date().toISOString().split('T')[0],
          logo: null,
          status: 'active',
          is_recurred: false,
        }
      };
    },
    methods: {
      handleLogoUpload(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        
        this.form.logo = file;
        
      
        const reader = new FileReader();
        reader.onload = (e) => {
          this.logoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      
      getFileName(file) {
        if (!file) return '';
        return file.name;
      },
      
      async validateAndSubmit() {
     
        this.errors = {};
        const today = new Date();
        const due_date = new Date(this.form.due_date);
        today.setHours(0,0,0,0);
        // Validate name
        if (!this.form.name || this.form.name.trim() === '') {
          this.errors.name = 'Please enter a bill name';
        }
        
        // Validate amount
        if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
          this.errors.amount = 'Please enter a valid amount';
        }
        
        // Validate bills_category
        if (!this.form.bills_category) {
          this.errors.bills_category = 'Please select a category';
        }
        
        // Validate frequency
        if (!this.form.frequency) {
          this.errors.frequency = 'Please select a frequency';
        }
        
        // Validate due_date
        if (!this.form.due_date) {
          this.errors.due_date = 'Please select a due date';
        }else if(today > due_date){
          this.errors.due_date = "you can't choose passed due_date";
        }
  
        if (Object.keys(this.errors).length > 0) {
          return;
        }
        
        this.isSubmitting = true;
        
        
        const formData = new FormData();
        formData.append('name', this.form.name);
        formData.append('amount', parseFloat(this.form.amount).toFixed(2));
        formData.append('category_id', this.form.bills_category);
        formData.append('frequency', this.form.frequency);
        formData.append('due_date', this.form.due_date);
        formData.append('status', this.form.status);
        formData.append('is_recurred', this.form.frequency !== 'one-time' ? '1' : '0');
        
       
        if (this.form.logo instanceof File) {
          formData.append('logo', this.form.logo);
        }
        
        try {
          await this.billStore.addbill(formData);
          this.$emit('bill-added');

          this.$notify({
        'title' : 'Created!',
        'type' : 'success',
        'text' : 'new bill created successfully'
      });

          this.$emit('close');
          this.resetForm();
        } catch (error) {
          console.error('Error adding bill:', error);

          this.$notify({
        'title' : 'Created!',
        'type' : 'error',
        'text' : 'faild to creat new bill'
      });

        } finally {
          this.isSubmitting = false;
        }
      },
      
      resetForm() {
        this.form = {
          name: '',
          amount: '',
          bills_category: '',
          frequency: '',
          due_date: new Date().toISOString().split('T')[0],
          logo: null,
          is_recurred: false,
        };
        this.logoPreview = null;
        this.errors = {};
        
       
        if (this.$refs.logoInput) {
          this.$refs.logoInput.value = '';
        }
      }
    }
  };
  </script>