<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Add New Category
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
                  placeholder="Clouths"
                  :class="{'border-red-500': errors.name}"
                />
              </div>
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
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
                Add category
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  

  <script>
  import { useCategoryStore } from '../../stores/categoryStore';
  export default {
    name: 'categoryForm',
    emits: ['category-added', 'close'],
    setup(){
      const CategoryStore = useCategoryStore()
      return { CategoryStore }
    },
    data() {
      return {
        isSubmitting: false,
        errors: {},
        form: {
          name: '',
        },
      }
    },
    methods: {
    async  validateAndSubmit() {
        // Reset errors
        this.errors = {};
        
        // Validate name
        if (!this.form.name.trim)  {
          this.errors.name = 'Please enter a valid name';
          return;
        }
       
        try{
             // Show loading state
        this.isSubmitting = true;
        
        // Generate category
        const newCategory = {
          name: this.form.name,
        };
          console.log(newCategory);
          
          await this.CategoryStore.addCategory(newCategory);
          this.$emit('reload-categories');
          this.$emit('close');
          this.resetForm();
        }catch(error){
          console.log(error);
          this.isSubmitting = false;
        }
      },
      
      resetForm() {
        this.form = {
          name: '',
        };
        this.errors = {};
      },
    }
  }
  </script>