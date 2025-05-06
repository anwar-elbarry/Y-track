<template>
  <Navbar />
    <div class="dashboard_container flex flex-col pt-22 px-7">
      <div class="cards gap-10 flex flex-wrap justify-evenly w-full">
          <Admin_card 
           :value="statistics.totalUsers"
           icon="md-accountbalancewallet"
           title="Total Users"
          />
          <Admin_card 
           :value="statistics.newUsers"
           title="New Users"
           icon="io-trending-down-outline"
           
          />
          <Admin_card 
           :value="statistics.activeUsers"
           title="Active Users"
           icon="bi-calendar-check-fill"
           
          />
      </div>
      <UsersTable />
      
    </div>
    </template>
    
    <script>
import UsersTable from '../../components/admin/usersTable.vue';
import Admin_card from '../../components/admin/admin_card.vue';
import adminService from '../../services/adminService';
import Navbar from '../../components/Navbar.vue';
    export default {
        name : 'adminDashboard',
        components : {
          Admin_card,
          UsersTable,
          Navbar
        },
        data(){
          return {
            statistics : []
          }
        },
        methods : {
          async getStatistics(){
           const data =  await adminService.getDashboardStats();
           this.statistics = data;
           console.log(data);
          }
        },
        created(){
          this.getStatistics();
        }
    }
    </script>
    