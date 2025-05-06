<template>
  <div class="flex flex-col w-full gap-7">
    <div class="up_content w-full justify-end items-center flex gap-5">
      <SearchBare
       title="Goal" />
      <AddBtn name="Add Goal" @click="showCreateGoalForm = true"/>
    </div>
    <div class="goals_cards flex flex-wrap justify-evenly gap-4">
      <goal-card v-for="goal in goals"
      :id="goal.id"
      :title="goal.title"
       :target="goal.target_amount" 
       :days-remaining="goal.formatted_deadline"
        icon-src="/icons/vacation.svg"
        :saved="goal.saved_amount"
        :percentage="goal.target_amount ? Math.min(Math.floor((goal.saved_amount / goal.target_amount) * 100), 100) : 0"
        @goal-to-update="sendSelectedGoal"
        @goal-to-remove="removeGoal"
        />
    
      <EmptyCard @click="showCreateGoalForm = true"/>
    </div>
    <CreateGoal 
    v-if="showCreateGoalForm" 
    :goals="goals"
    @create-goal="fetchGoals"
      @close="showCreateGoalForm = false"
    />
    <UpdateGoal 
    v-if="showUpdateGoalForm"
    @close="showUpdateGoalForm = false"
    @update-goal="handleUpdateGoal"
    :goalToUpdate="selectedGoal"
    />
  </div>

</template>
<script>

import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import CreateGoal from '../components/goals/CreateGoal.vue';
import EmptyCard from '../components/goals/emptyCard.vue';
import GoalCard from '../components/goals/goalCard.vue';
import UpdateGoal from '../components/goals/UpdateGoal.vue';
import { useGoalStore } from '../stores/goalStore';
export default {
  name: 'Goals',
  components: {
    GoalCard,
    EmptyCard,
    AddBtn,
    SearchBare,
    CreateGoal,
    UpdateGoal
  },
  data(){
    return {
      showCreateGoalForm: false,
      showUpdateGoalForm: false,
      goals : [],
      selectedGoal : null
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
    sendSelectedGoal(id){
        this.selectedGoal = this.goalStore.goals.find(goal => goal.id === id);
        this.showUpdateGoalForm = true;
    },
   async handleUpdateGoal(){
        await  this.fetchGoals();
        this.showUpdateGoalForm = false;
    },
   async removeGoal(id){
        this.goals = this.goals.filter(goal => goal.id !== id);
        await this.goalStore.removegoal(id);
    }
  },
  created(){
    this.fetchGoals();
  }
}
</script>