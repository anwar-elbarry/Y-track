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
        <transactionsChart 
          :transactions="transactions"
          :currency="currency"
          class="mb-4"
        />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <categoryChart 
            :expensecategories="expenseCategories" 
            :currency="currency"
          />
          <bills_category_chart 
            :billscategories="billsCategories"
            :currency="currency" 
          />
        </div>
        
    </div>
</template>

<script>
import transaction from '../services/transaction';
import Dash_card from '../components/dashboard/Dash_card.vue';
import transactionsChart from '../components/dashboard/transactionsChart.vue';
import categoryChart from '../components/dashboard/expense_Category_Chart.vue';
import { useCategoryStore } from '../stores/categoryStore';
import bills_category_chart from '../components/dashboard/bills_categories_chart.vue';
import { useBillCategoryStore } from '../stores/billsCategoryStore';
import auth from '../stores/auth';
const authStore = auth();
export default {
    name: 'DashboardHome',
    components : {
        Dash_card,
        transactionsChart,
        categoryChart,
        bills_category_chart
    },
    setup(){
      const categoryStore = useCategoryStore();
      const billscategoryStore = useBillCategoryStore();
      return {categoryStore,billscategoryStore};
    },
    data(){
      return {
        balance : 0,
        statistics : {},
        transactions : [],
        expenseCategories : [],
        billsCategories : [],
        currency: authStore.user.currency,
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
      async getBillsCategory(){
               await this.billscategoryStore.fetchCategories();
               this.billsCategories = this.billscategoryStore.categories;
      }
   },
   created(){
        this.getUser();
        this.getStatistics();
        this.getTransactions();
        this.getCategoryWithAmount();
        this.getBillsCategory();
   }
}

</script>