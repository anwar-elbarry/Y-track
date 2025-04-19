<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Income" />
            <AddBtn name="Add Income" @click="showForm = true"/>
        </div>
        
        <Income_table 
            :incomes="incomes"
            @reload-incomes="fetchIncomes()"
            @selected-income="showSelectedIncomeToUpdate"
        />
        
        <IncomeForm 
            v-if="showForm" 
            @close="showForm = false"
            @income-added="fetchIncomes()"
        />    

        <IncomeFormUpdate 
          v-if="showUpdate"
         :incomeToUpdate="selectedIncome"
         @income-updated="handleIncomeUpdate"
         @close="closeUpdateForm()"
/>
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Income_table from '../components/income/income_table.vue';
import IncomeForm from '../components/income/IncomeForm.vue';
import api from '../api';
import IncomeFormUpdate from '../components/income/incomeFormUpdate.vue';

export default {
    name: 'Incomes',
    components: {
        AddBtn,
        SearchBare,
        Income_table,
        IncomeForm,
        IncomeFormUpdate
    },
    data() {
        return {
            showForm: false,
            showUpdate: false,
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
        closeUpdateForm(){
            this.showUpdate = false;
        },
        showSelectedIncomeToUpdate(id){
            this.selectedIncome = this.incomes.find(income => income.id === id);
            this.showUpdate = true;
        }
    },
    created(){
        this.fetchIncomes();
    }
}
</script>