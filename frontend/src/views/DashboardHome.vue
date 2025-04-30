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
          <Dash_card 
           :value="statistics.totalClients"
           title="Clients"
           icon="la-user-friends-solid"
          /> 
        </div>
        <transactionsChart :transactions="transactions" />
        <categoryChart :expensecategories="expenseCategories" />
    </div>
</template>

<script>
import transaction from '../services/transaction';
import Dash_card from '../components/dashboard/Dash_card.vue';
import transactionsChart from '../components/dashboard/transactionsChart.vue';
import categoryChart from '../components/dashboard/expense_Category_Chart.vue';
import { useCategoryStore } from '../stores/categoryStore';
import auth from '../stores/auth';
const authStore = auth();
export default {
    name: 'DashboardHome',
    components : {
        Dash_card,
        transactionsChart,
        categoryChart
    },
    setup(){
      const categoryStore = useCategoryStore();
      return {categoryStore};
    },
    data(){
      return {
        balance : 0,
        statistics : {},
        transactions : [],
        expenseCategories : [],
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
      },
      async getCategoryWithAmount(){
        const data = await transaction.getCategoryWithAmount();
        this.expenseCategories = data.categories
      },
      // async getExpenseCategory(){
      //      await this.categoryStore.fetchCategories();
      //      this.expenseCategories = this.categoryStore.categories;
      // }
   },
   created(){
        this.getUser();
        this.getStatistics();
        this.getTransactions();
        this.getCategoryWithAmount();
   }
}

</script>