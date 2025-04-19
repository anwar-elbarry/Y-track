<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Income" />
            <AddBtn name="Add Income" @click="showForm = true"/>
        </div>
        
        <Income_table 
            :incomes="incomes"
            @reload-incomes="fetchIncomes()"
        />
        
        <IncomeForm 
            v-if="showForm" 
            @close="showForm = false"
            @income-added="fetchIncomes()"
        />    
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Income_table from '../components/income/income_table.vue';
import IncomeForm from '../components/income/IncomeForm.vue';
import api from '../api';

export default {
    name: 'Incomes',
    components: {
        AddBtn,
        SearchBare,
        Income_table,
        IncomeForm
    },
    data() {
        return {
            showForm: false,
            incomes: []
        }
    },
    methods: {
        handleIncomeSubmit() {
            this.showForm = false;
        },
        async fetchIncomes(){
            api.get('api/income/index')
            .then(response => {
                this.incomes = response.data.incomes
                console.log(response.data.incomes);
            })
            .catch(error =>{
                console.log(error);
            })
        },
    },
    created(){
        this.fetchIncomes();
    }
}
</script>