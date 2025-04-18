<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Income" />
            <AddBtn name="Add Income" @click="showForm = true"/>
        </div>
        
        <Income_table />
        
        <IncomeForm 
            v-if="showForm" 
            @close="showForm = false"
            @submit="handleIncomeSubmit"
        />    
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Income_table from '../components/income/income_table.vue';
import IncomeForm from '../components/income/IncomeForm.vue';

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
        handleIncomeSubmit(newIncome) {
            // Add new income to the list
            this.incomes.push(newIncome);
            
            // Close the form
            this.showForm = false;
            
            // Optional: You might want to save to backend or local storage
            this.saveIncomes();
        },
        saveIncomes() {
            // Implement saving logic (e.g., to local storage or backend)
            localStorage.setItem('incomes', JSON.stringify(this.incomes));
        },
        loadIncomes() {
            // Load incomes from storage
            const savedIncomes = localStorage.getItem('incomes');
            if (savedIncomes) {
                this.incomes = JSON.parse(savedIncomes);
            }
        },
    },
    mounted() {
        // Load existing incomes when component is mounted
        this.loadIncomes();
    }
}
</script>