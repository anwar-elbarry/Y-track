<template>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
      <!-- Header -->
      <div class="flex justify-between items-center mb-2">
        <div>
          <h1 class="text-2xl font-bold">Notifications</h1>
          <p class="text-gray-600">Stay updated on your financial activities and alerts</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="py-1 px-2 bg-gray-100 rounded-md text-sm">{{ unreadCount }} unread</span>
          <button @click="openSettings" class="p-2 text-gray-600 hover:text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.532 1.532 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </div>
  
      <!-- Tab Navigation -->
      <div class="bg-gray-100 rounded-lg p-1 flex mb-4">
        <button 
          v-for="tab in tabs" 
          :key="tab"
          @click="activeTab = tab"
          :class="[
            'flex-1 py-2 text-center rounded-md',
            activeTab === tab ? 'bg-white shadow-sm' : 'hover:bg-gray-200'
          ]"
        >
          {{ tab }}
        </button>
      </div>
      <!-- Notifications -->
      <div class="space-y-3">
        <div v-for="notification in notifications" :key="notification.id" class="border border-gray-200 rounded-lg p-4 flex justify-between">
          <div class="flex space-x-4">
            <div class="mt-1">
              <span v-if="notification.type === 'income'" class="text-green-500">
                <v-icon name="io-trending-up-outline" />
              </span>
              <span v-else-if="notification.type === 'bill'" class="text-purple-500">
                <v-icon name="bi-calendar-check-fill" />
              </span>
              <span v-else-if="notification.type === 'alert'" class="text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </span>
            </div>
            <div>
              <h3 class="font-medium">{{ notification.message }}</h3>
            </div>
          </div>
          <div class="text-sm text-gray-500 whitespace-nowrap">
            {{ notification.created_at }}
          </div>
        </div>
      </div>
  
      <!-- Settings Modal -->
      <div v-if="showSettings" class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg max-w-2xl w-full h-11/12  overflow-y-auto">
          <div class="mt-4 p-6">
            <h3 class="text-xl font-medium mb-2">Notification Settings</h3>
            <p class="text-gray-600 mb-4">Customize how and when you receive notifications</p>

            <!-- Alert Preferences Tab -->
            <div>
              <div class="mb-6">
                <h4 class="font-medium mb-2">Spending Threshold Alert</h4>
                <div class="flex items-center">
                  <span class="mr-2">$</span>
                  <input type="text" v-model="settings.spendingThreshold" class="border border-gray-300 rounded p-2 w-32">
                </div>
                <p class="text-gray-600 text-sm mt-1">You'll be notified when spending exceeds this amount</p>
              </div>
              <div>
                <h4 class="font-medium mb-3">Bill Reminders</h4>
                
                <div class="mb-3 flex justify-between items-center">
                  <span>Bill payment reminders</span>
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" v-model="settings.billReminders" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                  </label>
                </div>
              </div>
            </div>
          </div>
  
          <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 rounded-b-lg">
            <button @click="closeSettings" class="px-4 py-2 border border-gray-300 rounded bg-white hover:bg-gray-100">
              Cancel
            </button>
            <button @click="saveSettings" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useNotificationStore } from '../../stores/notificationStore';

  export default {
    name: 'notification_component',
    setup() {
      const notificationStore = useNotificationStore();
      return {
        notificationStore
      }
    },
    props: {
      notifications: {
        type: Array,
        required: true
      },
      unreadCount: {
        type: Number,
        required: true
      }
    },

    methods: {
      openSettings() {
        this.showSettings = true
      },
      closeSettings() {
        this.showSettings = false
      },
    }
  }
  </script>