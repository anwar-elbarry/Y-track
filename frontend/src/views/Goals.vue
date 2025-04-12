<template>
    <div class="goals_cards flex flex-wrap gap-2">
        <goal-card 
          title="Vacation Fund"
          :target="5000"
          :days-remaining="45"
          icon-src="/icons/vacation.svg"
          :saved="2500"
          :percentage="50"
/>
        <goal-card 
          title="Vacation Fund"
          :target="5000"
          :days-remaining="45"
          icon-src="/icons/vacation.svg"
          :saved="2500"
          :percentage="50"
/>
        <goal-card 
          title="Vacation Fund"
          :target="5000"
          :days-remaining="45"
          icon-src="/icons/vacation.svg"
          :saved="2500"
          :percentage="50"
/>
        <goal-card 
          title="Vacation Fund"
          :target="5000"
          :days-remaining="45"
          icon-src="/icons/vacation.svg"
          :saved="2500"
          :percentage="50"
/>
        <goal-card 
          title="Vacation Fund"
          :target="5000"
          :days-remaining="45"
          icon-src="/icons/vacation.svg"
          :saved="2500"
          :percentage="50"
/>
<EmptyCard />
    </div>
</template>
<script>

import EmptyCard from '../components/goals/emptyCard.vue';
import GoalCard from '../components/goals/goalCard.vue';

export default {
    name : 'Goals',
    components : {
        GoalCard,
        EmptyCard
    }
}
</script>