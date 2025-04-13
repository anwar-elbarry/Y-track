<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        
        <transictionHistory_table />
         
    </div>
</template>

<script>
import transictionHistory_table from '../components/transictions/transictionHistory_table.vue';

export default {
    name: 'Transactions_History',
    components: {
        transictionHistory_table
    }
}
</script>