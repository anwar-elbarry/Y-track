<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
      <SearchBare
       title="Goal" />
      <AddBtn name="Add Goal" @click="showCreateGoalForm = true"/>
    </div>
    <Income_table />
    </div>
</template>
<script>

import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Income_table from '../components/income/income_table.vue';

export default {
    name : 'Incomes',
    components : {
        AddBtn,
        SearchBare,
        Income_table
    }
}

</script>