<template>
<div class="dashboard_container flex">
    <dash_Aside  
    :user="user"
    :is-open="isAsideOpen"
    @toggle-aside="handleAsideToggle"
    />
    <main :class="[
        'flex-grow p-5 transition-all duration-300',
        isAsideOpen ? 'ml-54' : 'ml-0'
      ]">
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
    </main>
        
</div>
</template>

<script>
import auth from '../stores/auth';
import dash_Aside from '../components/Aside.vue';
export default {
    name : 'Dashboard',
    components : {
        dash_Aside
    },
    data(){
      return {
        isAsideOpen : true,
        user : auth().user
      }
    },
    methods : {
      handleAsideToggle(isOpen){
        this.isAsideOpen = isOpen;
      }
    }
}
</script>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
