<template>
    <div class="fixed inset-0 backdrop-blur-xl z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
      <h2 class="text-2xl font-bold mb-6 text-center">Update Goal</h2>
      
    
      <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ errorMessage }}</span>
      </div>

      <form @submit.prevent="submitGoal" class="space-y-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Save amount</label>
            <input 
              v-model.number="form.saved_amount" 
              type="number" 
              placeholder="save amount" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
              :class="{'border-red-500': errors.saved_amount}"
              required
            />
            <p v-if="errors.saved_amount" class="text-red-500 text-xs mt-1">
              {{ errors.saved_amount }}
            </p>
          </div>
        </div>

        <div class="flex justify-between space-x-4">
          <button 
            type="button" 
            @click="$emit('close')"
            class="cursor-pointer w-full py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100"
          >
            Cancel
          </button>
          <button 
            type="submit" 
            class="cursor-pointer px-2 w-1/2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200 flex items-center justify-center"
            :disabled="isSubmitting"
          >
            <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Save Amount
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useGoalStore } from '../../stores/goalStore';
export default {
  name: 'UpdateGoalForm',
  props: {
    goalToUpdate: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      form: {
        saved_amount: '',
      },
      isSubmitting: false,
      errorMessage: '',
      errors: {
        saved_amount: '',
      }
    }
  },
  setup(){
    const goalStore = useGoalStore();
    return { goalStore }
  },
  emits: ['update-goal','close'],
  methods: {
    async submitGoal() {
 
      this.errorMessage = '';

      if (!this.form.saved_amount) {
        this.errorMessage = 'Save amount is required';
        return;
      }
      else if(this.goalToUpdate.saved_amount == this.goalToUpdate.target_amount){
        return this.errorMessage = 'The goal is already achieved';
      }else if(this.form.saved_amount > this.goalToUpdate.target_amount){
        return this.errors.saved_amount = 'Total saved amount cannot exceed target amount';
      }
      

      this.isSubmitting = true;

      const updatedGoal = {
        'saved_amount': this.form.saved_amount,
      };

      try {
        await this.goalStore.updategoal(this.goalToUpdate.id, updatedGoal);
        this.$emit('update-goal');
        this.$emit('close');
      } catch(error) {
        this.errorMessage = error.response?.data?.message || 
          'An error occurred while updating the goal';
      } finally {
        this.isSubmitting = false;
      }
    },
  },
}
</script>