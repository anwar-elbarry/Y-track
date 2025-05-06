<template>
    <div class="fixed inset-0 backdrop-blur-xl z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl">
      <h2 class="text-2xl font-bold mb-6 text-center">Create New Goal</h2>
      
      <form @submit.prevent="submitGoal" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Goal Title</label>
          <input 
            v-model="goal.title" 
            type="text" 
            placeholder="e.g., Vacation Fund" 
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
            required
          />
          <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Target Amount</label>
            <input 
              v-model.number="goal.target" 
              type="number" 
              placeholder="5000" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
              required
            />
            <p v-if="errors.target" class="mt-1 text-sm text-red-600">{{ errors.target }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Target Date</label>
            <input 
              v-model="goal.due_date" 
              type="date" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
              required
            />
            <p v-if="errors.due_date" class="mt-1 text-sm text-red-600">{{ errors.due_date }}</p>
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
                class="cursor-pointer px-2 w-1/2 border border-transparent rounded-md shadow-sm text-sm  font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200 flex items-center justify-center"
                :disabled="isSubmitting"
              >
                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Add Goal
              </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useGoalStore } from '../../stores/goalStore';
export default {
  name: 'CreateGoalForm',
  data() {
    return {
      goal: {
        title: '',
        target: null,
        due_date: null,
      },
      errors : {},
      isSubmitting: false,
    }
  },
  setup(){
    const goalStore = useGoalStore();
    return { goalStore }
  },
  props : {
    goals :{
      type : Array,
      required : true
    }
  },
  emits : ['create-goal','close'],
  methods: {
    async submitGoal() {
          this.errors = {};
          const today =  new Date();
          today.setHours(0,0,0,0);
          const due_date = new Date(this.goal.due_date);

      if (!this.goal.title && !this.goal.target && !this.goal.due_date) {
        alert('Please fill in all fields');
        return;
      }
      if (!this.goal.title) {
          this.errors.title = 'Please enter a valid title';
      }else if(this.goals.find(goal => goal.title === this.goal.title)){
        this.errors.title = 'this title is alredy taken';
      }
      if (!this.goal.due_date) {
          this.errors.due_date = 'Please enter a valid title';
      }else if(due_date < today){
        this.errors.due_date = "you can't select passed date";
      }
      if (!this.goal.target || parseFloat(this.goal.target) <= 0) {
          this.errors.target = 'Please enter a valid amount';
        }

      if(Object.keys(this.errors).length > 0){
        return;
      }
      this.isSubmitting = true;
      const newGoal = {
        'title':this.goal.title,
        'due_date': this.goal.due_date,
        'target_amount': this.goal.target,
      };
      try{
        await this.goalStore.addgoal(newGoal);
        this.$notify({
            title: 'Created!',
            text: 'Goal was successfully Created.',
            type: 'success',
          })
        this.$emit('create-goal');
        this.$emit('close');
        this.isSubmitting = false;
      }catch(error){
         console.log(error);
      }
    },
    restForm(){
      this.goal = {
        title: '',
        target: null,
        due_date: null,
      };
    }
  }
}
</script>