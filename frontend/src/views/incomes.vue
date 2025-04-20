<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Income" />
            <AddBtn name="Add Income" @click="showForm = true"/>
        </div>
        
        <Income_table 
            :incomes="incomeStore.incomes"
            @reload-incomes="fetchIncomes"
            @selected-income="showSelectedIncomeToUpdate"
        />
        
        <IncomeForm 
            v-if="showForm" 
            @close="showForm = false"
            @income-added="fetchIncomes"
        />    

        <IncomeFormUpdate 
            v-if="showUpdate"
            :incomeToUpdate="selectedIncome"
            @income-updated="handleIncomeUpdate"
            @close="closeUpdateForm"
        />
    </div>
</template>

<script>
import { useIncomeStore } from '../stores/incomeStore'
import AddBtn from '../components/dashboard/addBtn.vue'
import SearchBare from '../components/dashboard/searchBare.vue'
import Income_table from '../components/income/income_table.vue'
import IncomeForm from '../components/income/IncomeForm.vue'
import IncomeFormUpdate from '../components/income/incomeFormUpdate.vue'

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
            selectedIncome: null
        }
    },
    setup() {
        const incomeStore = useIncomeStore()
        return { incomeStore }
    },
    methods: {
        handleIncomeSubmit() {
            this.showForm = false
        },
        async fetchIncomes() {
            await this.incomeStore.fetchIncomes()
        },
        closeUpdateForm() {
            this.showUpdate = false
            this.selectedIncome = null
        },
        showSelectedIncomeToUpdate(id) {
            this.selectedIncome = this.incomeStore.incomes.find(income => income.id === id)
            this.showUpdate = true
        },
        async handleIncomeUpdate() {
            await this.fetchIncomes()
            this.closeUpdateForm()
        }
    },
    created() {
        this.fetchIncomes()
    }
}
</script>