<template>
  <div class="flex flex-col w-full gap-7">
    <div class="up_content w-full justify-end items-center flex gap-5">
      <SearchBare
       title="Goal" />
      <AddBtn name="Add Goal" @click="showCreateGoalForm = true"/>
    </div>
    <div class="goals_cards flex flex-wrap justify-evenly gap-4">
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <goal-card title="Vacation Fund" :target="5000" :days-remaining="45" icon-src="/icons/vacation.svg" :saved="2500"
        :percentage="50" />
      <EmptyCard @click="showCreateGoalForm = true"/>
    </div>
    <CreateGoal 
    v-if="showCreateGoalForm" 
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
    }
  },
  methods : {
    addGoal() {
      this.showCreateGoalForm = false;
    }
  }
}
</script>