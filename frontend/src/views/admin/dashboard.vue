<template>
    <div class="dashboard_container flex flex-col">
      <div class="cards gap-10 flex flex-wrap justify-center w-full">
          <Dash_card 
           :value="455"
           icon="md-accountbalancewallet"
           title="Total Users"
          />
          <Dash_card 
           :value="3534"
           title="Active Users"
           icon="io-trending-down-outline"
           
          />
          <Dash_card 
           :value="4365"
           title="Suspended Users"
           icon="bi-calendar-check-fill"
           
          />
      </div>
      <UsersTable />
    </div>
    </template>
    
    <script>
    import Dash_card from '../../components/dashboard/Dash_card.vue';
    import UsersTable from '../../components/admin/usersTable.vue';
    export default {
        name : 'adminDashboard',
        components : {
          Dash_card,
          UsersTable
        }
    }
    </script>
    