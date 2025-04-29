<template>
        <div class="cards gap-10 flex flex-wrap justify-center w-full">
          <Dash_card 
           :value="balance"
           icon="md-accountbalancewallet"
           title="Balance"
          />
          <Dash_card 
           :value="3000"
           title="Expenses"
           icon="io-trending-down-outline"
           
          />
          <Dash_card 
           :value="3000"
           title="Bills"
           icon="bi-calendar-check-fill"
           
          />
          <Dash_card 
           :value="3000"
           title="Total incomes"
           icon="io-trending-up-outline"

          />
        </div>
</template>

<script>

import Dash_card from '../components/dashboard/Dash_card.vue';
import auth from '../stores/auth';
const authStore = auth();
export default {
    name: 'DashboardHome',
    components : {
        Dash_card
    },
    data(){
      return {
        balance : 0,
      }
    }
   ,
   methods : {
     async getUser(){
            await authStore.fetchUser();
            this.balance = authStore.user.balance;
            console.log(this.balance);
            
      }
   },
   created(){
        this.getUser();
   }
}

</script>