<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <AddBtn name="Add Income" @click="showForm = true"/>
        </div>
        
        <Income_table 
            :incomes="incomes"
            @delete-income="handleincomeRemove"
            @selected-income="showSelectedIncomeToUpdate"
            @update-income-status="handleincomeStatus"
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
            incomes : [],
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
            await this.incomeStore.fetchIncomes();
            this.incomes = this.incomeStore.incomes;
        },
        async handleincomeRemove(id) {
            await this.incomeStore.removeIncome(id);
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
        },
        async handleincomeStatus(incomeId,data) {
            await this.incomeStore.updateIncome(incomeId, data);
            await this.fetchIncomes();
        }
    },
    created() {
        this.fetchIncomes()
    }
}
</script>