<template>
    <div class="Expences_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Expence" />
            <AddBtn @click="openForm = true" name="Add Expence"/>
        </div>
        <Expence_table 
        :expenses="expenses"
        @reload-expenses="fetchExpenses"
        @selected-expense="openForm = true"
        />
        <Expence_form 
        v-if="openForm"
        @close="closeForm"
        @reload-expenses="fetchExpenses"
        />
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Expence_form from '../components/expences/expence_form.vue';
import Expence_table from '../components/expences/expence_table.vue';
import { useExpenseStore } from '../stores/expenseStore';
export default {
    name: 'Expences',
    components: {
        AddBtn,
        SearchBare,
        Expence_table,
        Expence_form
    },
    setup(){
        const expenseStore = useExpenseStore()
        return { expenseStore }
    },
    data(){
        return {
            openForm : false,
            expenses: []
        }
    },
    methods : {
        closeForm(){
            this.openForm = false;
        },
        async fetchExpenses(){
            await this.expenseStore.fetchExpenses()
            this.expenses = this.expenseStore.expenses
            console.log('expenses in table :',this.expenses);
            
        }
    },
    created(){
        this.fetchExpenses();
    }
}
</script>