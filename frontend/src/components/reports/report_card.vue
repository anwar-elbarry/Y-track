<template>
    <div class="bg-white rounded-lg  shadow-md hover:shadow-2xl p-5 max-w-md ">
      <div class="flex justify-between items-start mb-5">
        <div>
          <h2 class="font-semibold text-lg text-gray-800">{{ title }}</h2>
          <p class="text-gray-500 text-sm">{{ dateRange }}</p>
        </div>
        <div>
          <button v-if="showExpandButton" class="cursor-pointer" @click="$emit('expand')">
            <v-icon name="io-arrow-forward-circle-outline" />
          </button>
        </div>
      </div>
      
      <p class="text-gray-600 text-sm mb-6">
        {{ description }}
      </p>
      
      <div class="flex items-center text-sm text-black border-t border-gray-200 pt-4">
        <span class="mr-4">Generated: {{ generatedDate }}</span>
        
        <button 
          v-if="pdfEnabled" 
          class="flex items-center mr-4 hover:text-gray-800 border-2 border-gray-200 rounded p-1 cursor-pointer"
          @click="$emit('download-pdf')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
          {{ pdfLabel }}
        </button>
        
        <button 
          v-if="csvEnabled" 
          class="flex items-center hover:text-gray-800 border-2 border-gray-200 rounded p-1 cursor-pointer"
          @click="$emit('download-csv')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
          {{ csvLabel }}
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'report_card',
    props: {
      // Main content props
      title: {
        type: String,
        default: 'Q2 Financial Summary'
      },
      dateRange: {
        type: String,
        default: 'April - June 2023'
      },
      description: {
        type: String,
        default: 'Complete financial overview for Q2 including income, expenses, and profit analysis.'
      },
      generatedDate: {
        type: String,
        default: 'July 1, 2023'
      },
      
      // UI control props
      showExpandButton: {
        type: Boolean,
        default: true
      },
      
      // Download options
      pdfEnabled: {
        type: Boolean,
        default: true
      },
      csvEnabled: {
        type: Boolean,
        default: true
      },
      pdfLabel: {
        type: String,
        default: 'PDF'
      },
      csvLabel: {
        type: String,
        default: 'CSV'
      }
    },
    emits: ['expand', 'download-pdf', 'download-csv']
  }
  </script>