<template>
    <div class="dashboard-home">
        <div class="cards gap-10 flex flex-wrap justify-center w-full">
          <Dash_card 
           :value="balance"
           icon="md-accountbalancewallet"
           title="Balance"
          />
          <Dash_card 
           :value="statistics.totalExpenses"
           title="Expenses"
           icon="io-trending-down-outline"
           
          />
          <Dash_card 
           :value="statistics.totalBills"
           title="Bills"
           icon="bi-calendar-check-fill"
           
          />
          <Dash_card 
           :value="statistics.totalIncomes"
           title="Total incomes"
           icon="io-trending-up-outline"

          />
        </div>
        <charts :transactions="transactions" />
    </div>
</template>

<script>
import transaction from '../services/transaction';
import Dash_card from '../components/dashboard/Dash_card.vue';
import charts from '../components/dashboard/charts.vue';
import auth from '../stores/auth';
const authStore = auth();
export default {
    name: 'DashboardHome',
    components : {
        Dash_card,
        charts
    },
    data(){
      return {
        balance : 0,
        statistics : {},
        transactions : []
      }
    }
   ,
   methods : {
     async getUser(){
            await authStore.fetchUser();
            this.balance = authStore.user.balance;
            console.log(this.balance);
            
      },
      async getStatistics(){
            await authStore.getStatistics();
            this.statistics = authStore.statistics;
      },
      async getTransactions(){
        const data = await transaction.getAll();
        this.transactions = data.transactions
      }
   },
   created(){
        this.getUser();
        this.getStatistics();
        this.getTransactions();
   }
}

</script>