<template>
        <div class="cards gap-2 flex flex-wrap w-full">
          <Dash_card 
           :value="300"
           title="Income"
           
          />
          <Dash_card 
           :value="3000"
           title="Income"
           
          />
          <Dash_card 
           :value="3000"
           title="Income"
           
          />
          <Dash_card 
           :value="3000"
           title="Income"
           
          />
        </div>
</template>

<script>

import Dash_card from '../components/dashboard/Dash_card.vue';

export default {
    name: 'DashboardHome',
    components : {
        Dash_card
    }
   
}

</script>