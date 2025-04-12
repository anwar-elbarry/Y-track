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
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Target Date</label>
            <input 
              v-model="goal.targetDate" 
              type="date" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
              required
            />
          </div>
        </div>

        <div class="flex justify-between space-x-4">
          <button 
            type="button" 
            @click="$emit('close')"
            class="w-full py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100"
          >
            Cancel
          </button>
          <button 
            type="submit" 
            class="w-full py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700"
          >
            Create Goal
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateGoalForm',
  data() {
    return {
      goal: {
        title: '',
        target: null,
        targetDate: null,
      }
    }
  },
  methods: {
    submitGoal() {
      // Validate form
      if (!this.goal.title || !this.goal.target || !this.goal.targetDate || !this.goal.icon) {
        alert('Please fill in all fields');
        return;
      }

      // Calculate days remaining
      const targetDate = new Date(this.goal.targetDate);
      const today = new Date();
      const daysRemaining = Math.ceil((targetDate - today) / (1000 * 60 * 60 * 24));

      const newGoal = {
        ...this.goal,
        daysRemaining,
        saved: 0,
        percentage: 0
      };

      // Emit event with new goal
      this.$emit('create-goal', newGoal);

      // Reset form
      this.goal = {
        title: '',
        target: null,
        targetDate: null,
      };
    }
  }
}
</script>