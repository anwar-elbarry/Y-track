<template>
    <div class="app-container">
      <Notifications />
      <main>
        <router-view v-slot="{ Component }">
          <transition name="fade" mode="out-in">
            <component :is="Component" />
          </transition>
        </router-view>
      </main>
    </div>
  </template>
  
  <script>

import { Notifications } from '@kyvg/vue3-notification';

  export default {
    name: 'App',
    components : {
      Notifications
    }
  }
  </script>
  
  <style>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  