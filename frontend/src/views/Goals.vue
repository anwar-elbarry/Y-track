<template>
  <div class="flex flex-col w-full gap-7">
    <div class="up_content w-full justify-end items-center flex gap-5">
      <SearchBare
       title="Goal" />
      <AddBtn name="Add Goal" @click="showCreateGoalForm = true"/>
    </div>
    <div class="goals_cards flex flex-wrap justify-evenly gap-4">
      <goal-card v-for="goal in goals"
      :title="goal.title"
       :target="goal.target_amount" 
       :days-remaining="goal.formatted_deadline"
        icon-src="/icons/vacation.svg"
        :saved="goal.saved_amount"
        :percentage="Math.round((goal.saved_amount / goal.target_amount) * 100)" />
    
      <EmptyCard @click="showCreateGoalForm = true"/>
    </div>
    <CreateGoal 
    v-if="showCreateGoalForm" 
    @create-goal="fetchGoals"
      @close="showCreateGoalForm = false"
    />
  </div>

</template>
<script>

import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import CreateGoal from '../components/goals/CreateGoal.vue';
import EmptyCard from '../components/goals/emptyCard.vue';
import GoalCard from '../components/goals/goalCard.vue';
import { useGoalStore } from '../stores/goalStore';
export default {
  name: 'Goals',
  components: {
    GoalCard,
    EmptyCard,
    AddBtn,
    SearchBare,
    CreateGoal
  },
  data(){
    return {
      showCreateGoalForm: false,
      goals : []
    }
  },
  setup(){
    const goalStore = useGoalStore();
    return {goalStore}
  },
  methods : {
    addGoal() {
      this.showCreateGoalForm = false;
    },
    async fetchGoals(){
      await this.goalStore.fetchgoals();
      this.goals = this.goalStore.goals;
    },
  },
  created(){
    this.fetchGoals();
  }
}
</script>