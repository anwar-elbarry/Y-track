<template>
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow">
      <!-- Header -->
      <div class="flex justify-between items-center mb-2">
        <div>
          <h1 class="text-2xl font-bold">Notifications</h1>
          <p class="text-gray-600">Stay updated on your financial activities and alerts</p>
        </div>
        <div class="flex items-center space-x-2">
          <span class="py-1 px-2 bg-gray-100 rounded-md text-sm">{{ unreadCount }} unread</span>
          <button @click="openSettings()" class="p-2 text-gray-600 hover:text-gray-800">
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
          <div class="flex space-x-4 justify-between items-center w-full">
            <div class="flex space-x-4">
              <div class="mt-1">
                <span v-if="notification.type === 'income'" class="text-green-500">
                  <v-icon name="io-trending-up-outline" />
                </span>
                <span v-else-if="notification.type === 'bill'" class="text-purple-500">
                  <v-icon name="bi-calendar-check-fill" />
                </span>
                <span v-else-if="notification.type === 'alert'" class="text-yellow-500">
                  <v-icon name="oi-alert" />
                </span>
              </div>
              <div>
                <h3 class="font-medium">{{ notification.message }}</h3>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <div class="text-sm text-gray-500 whitespace-nowrap">
                {{ formatDate(notification.created_at) }}
              </div>
              <button 
                v-if="!notification.is_read"
                @click="markAsRead(notification.id)" 
                class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full transition-colors"
              >
                Mark as read
              </button>
            </div>
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
                  <span class="mr-2">{{ currency }}</span>
                  <input type="number" min="0" step="0.01" v-model="settings.spendingThreshold" class="border border-gray-300 rounded p-2 w-32">
                </div>
                <p class="text-gray-600 text-sm mt-1">You'll be notified when spending exceeds this amount</p>
              </div>
            </div>
          </div>
  
          <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 rounded-b-lg">
            <button @click="closeSettings" class="cursor-pointer px-4 py-2 border border-gray-300 rounded bg-white hover:bg-gray-100">
              Cancel
            </button>
            <button @click="saveSettings" class="cursor-pointer px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import {format} from 'timeago.js'
  export default {
    name: 'notification_component',
    data() {
      return {
        showSettings: false,
        activeTab: 'All',
        tabs: ['All', 'Bills','incomes', 'Alerts'],
        settings: {
          spendingThreshold: this.threshold_alert ? this.threshold_alert : 0,
        }
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
      },
      threshold_alert: {
        type: Number,
        required: true
      },
      currency: {
        type: String,
        required: true
      }
    },
    emits: ['threshold_alert', 'mark-as-read'],
    computed: {
      formatDate() {
        return (date) => format(date)
      }
    },
    methods: {
      openSettings() {
        this.showSettings = true;
      },
      closeSettings() {
        this.showSettings = false;
      },
      saveSettings() {
        this.showSettings = false;
        this.$emit('threshold_alert', this.settings.spendingThreshold);
        this.closeSettings();
      },
      markAsRead(notificationId) {
        this.$emit('mark-as-read', notificationId);
      }
    }
  }
  </script>