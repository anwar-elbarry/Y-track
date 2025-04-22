<template>
    <div class="incomes_container flex flex-col w-full h-full gap-4">
        
        <transictionHistory_table 
        :transacrion-items="transactions"/>
         
    </div>
</template>

<script>
import transictionHistory_table from '../components/transictions/transictionHistory_table.vue';
import { useTransactionStore } from '../stores/transactionStore';
export default {
    name: 'Transactions_History',
    components: {
        transictionHistory_table
    },
    setup(){
        const transactionStore = useTransactionStore();
        return {transactionStore}
    },
    data(){
        return {
            transactions : []
        }
    },
    methods : {
        async fetchTransactions(){
           await this.transactionStore.fetchtransactions();
            this.transactions = this.transactionStore.transactions;
        }
    },
    created(){
        this.fetchTransactions();
    }
}
</script>