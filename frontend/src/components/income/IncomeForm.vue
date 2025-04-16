<template>
  <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
          Add New Income
        </h2>
      
        <form @submit.prevent="validateAndSubmit" class="space-y-5">
          <!-- Amount Field -->
          <div>
            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount*</label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm">{{ favCurrency }}</span>
              </div>
              <input 
                type="number" 
                id="amount" 
                v-model="form.amount" 
                class="block w-full pl-4 pr-8 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="0.00"
                min="0"
                step="0.01"
                :class="{'border-red-500': errors.amount}"
              />
            </div>
            <p v-if="errors.amount" class="mt-1 text-sm text-red-600">{{ errors.amount }}</p>
          </div>
          
          <!-- Date Field -->
          <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date*</label>
            <input 
              type="date" 
              id="date" 
              v-model="form.date" 
              class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
              :class="{'border-red-500': errors.date}"
            />
            <p v-if="errors.date" class="mt-1 text-sm text-red-600">{{ errors.date }}</p>
          </div>
          
          <!-- Source Type Selection -->
          <div>
            <label for="sourceType" class="block text-sm font-medium text-gray-700 mb-1">Source Type*</label>
            <div class="grid grid-cols-2 gap-4">
              <div 
                @click="form.sourceType = 'client'" 
                class="flex items-center p-3 border rounded-md cursor-pointer"
                :class="[form.sourceType === 'client' ? 'border-orange-500 bg-orange-50' : 'border-gray-300']"
              >
                <div class="h-5 w-5 mr-2">
                  <div v-if="form.sourceType === 'client'" class="h-full w-full rounded-full bg-orange-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div v-else class="h-full w-full rounded-full border-2 border-gray-300"></div>
                </div>
                <span class="text-sm font-medium">Client</span>
              </div>
              <div 
                @click="form.sourceType = 'other'" 
                class="flex items-center p-3 border rounded-md cursor-pointer"
                :class="[form.sourceType === 'other' ? 'border-orange-500 bg-orange-50' : 'border-gray-300']"
              >
                <div class="h-5 w-5 mr-2">
                  <div v-if="form.sourceType === 'other'" class="h-full w-full rounded-full bg-orange-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div v-else class="h-full w-full rounded-full border-2 border-gray-300"></div>
                </div>
                <span class="text-sm font-medium">Other</span>
              </div>
            </div>
          </div>
          
          <!-- Client Selection (when sourceType is client) -->
          <div v-if="form.sourceType === 'client'" class="transition-all duration-300">
            <label for="client" class="block text-sm font-medium text-gray-700 mb-1">Client*</label>
            <div class="relative">
              <select 
                id="client" 
                v-model="form.client" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                :class="{'border-red-500': errors.client}"
              >
                <option value="" disabled>Select a client</option>
                <option v-for="client in clients" :key="client.id" :value="client.id">
                  {{ client.name }}
                </option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <p v-if="errors.client" class="mt-1 text-sm text-red-600">{{ errors.client }}</p>
            
            <div v-if="selectedClientDetails" class="mt-2 bg-gray-50 p-3 rounded-md border border-gray-200">
              <p class="text-sm text-gray-600">{{ selectedClientDetails.email }}</p>
            </div>
          </div>
          
          <!-- Custom Source (when sourceType is other) -->
          <div v-if="form.sourceType === 'other'" class="transition-all duration-300">
            <label for="customSource" class="block text-sm font-medium text-gray-700 mb-1">Source Name*</label>
            <input 
              type="text" 
              id="customSource" 
              v-model="form.customSource" 
              class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
              placeholder="e.g., Digital Product Sales"
              :class="{'border-red-500': errors.customSource}"
            />
            <p v-if="errors.customSource" class="mt-1 text-sm text-red-600">{{ errors.customSource }}</p>
          </div>
          
          <!-- Frequency Field -->
          <div>
            <label for="frequency" class="block text-sm font-medium text-gray-700 mb-1">Frequency*</label>
            <div class="relative">
              <select 
                id="frequency" 
                v-model="form.frequency" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500 appearance-none"
                :class="{'border-red-500': errors.frequency}"
              >
                <option value="One-Time">One-Time</option>
                <option value="Weekly">Weekly</option>
                <option value="Monthly">Monthly</option>
                <option value="Quarterly">Quarterly</option>
                <option value="Annually">Annually</option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </div>
            </div>
            <p v-if="errors.frequency" class="mt-1 text-sm text-red-600">{{ errors.frequency }}</p>
          </div>
          
          <!-- Form Actions -->
          <div class="flex items-center justify-end space-x-3 pt-2">
            <button 
              type="button" 
              class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200"
              @click="$emit('close')"
            >
              Cancel
            </button>
            <button 
              type="submit" 
              class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors duration-200 flex items-center"
              :disabled="isSubmitting"
            >
              <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Add Income
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'IncomeForm',
  emits: ['income-added', 'close'],
  data() {
    return {
      favCurrency : 'DH',
      isSubmitting: false,
      errors: {},
      form: {
        amount: '',
        currency: 'DH',
        date: new Date().toISOString().substr(0, 10), // Today's date in YYYY-MM-DD format
        sourceType: 'client',
        client: '',
        customSource: '',
        status: 'Active',
        frequency: 'One-Time',
        description: ''
      },
      clients: [
        { id: 1, name: 'Olivia Rhye', email: 'olivia@untitledui.com' },
        { id: 2, name: 'Lana Steiner', email: 'lana@untitledui.com' },
        { id: 3, name: 'Demi Wilkinson', email: 'demi@untitledui.com' },
        { id: 4, name: 'Candice Wu', email: 'candice@untitledui.com' },
        { id: 5, name: 'Natali Craig', email: 'natali@untitledui.com' },
        { id: 6, name: 'Drew Cano', email: 'drew@untitledui.com' }
      ]
    }
  },
  computed: {
    selectedClientDetails() {
      if (!this.form.client) return null;
      return this.clients.find(c => c.id === parseInt(this.form.client));
    }
  },
  methods: {
    validateAndSubmit() {
      // Reset errors
      this.errors = {};
      
      // Validate amount
      if (!this.form.amount || parseFloat(this.form.amount) <= 0) {
        this.errors.amount = 'Please enter a valid amount';
      }
      
      // Validate date
      if (!this.form.date) {
        this.errors.date = 'Please select a date';
      }
      
      // Validate client if sourceType is client
      if (this.form.sourceType === 'client' && !this.form.client) {
        this.errors.client = 'Please select a client';
      }
      
      // Validate customSource if sourceType is other
      if (this.form.sourceType === 'other' && !this.form.customSource) {
        this.errors.customSource = 'Please enter a source name';
      }
      
      // Validate frequency
      if (!this.form.frequency) {
        this.errors.frequency = 'Please select a frequency';
      }
      
      // If there are errors, don't submit
      if (Object.keys(this.errors).length > 0) {
        return;
      }
      
      // Show loading state
      this.isSubmitting = true;
      
      // Generate a new income entry based on form data
      const newIncome = {
        id: `#${Math.floor(1000 + Math.random() * 9000)}`, // Generate a random 4-digit ID
        amount: parseFloat(this.form.amount),
        currency: this.form.currency,
        date: this.formatDate(this.form.date),
        source: this.form.sourceType === 'client' 
          ? this.getClientName(this.form.client)
          : this.form.customSource,
        email: this.form.sourceType === 'client' 
          ? this.getClientEmail(this.form.client)
          : null,
        status: this.form.status,
        frequency: this.form.frequency,
        description: this.form.description || null
      };
      
      // Simulate API call
      setTimeout(() => {
        // Here you would typically send the data to your API
        console.log('New income entry:', newIncome);
        
        // Emit event to pass data to parent component
        this.$emit('income-added', newIncome);
        
        // Reset the form after submission
        this.resetForm();
        
        // Hide loading state
        this.isSubmitting = false;
      }, 600);
    },
    
    resetForm() {
      this.form = {
        amount: '',
        currency: 'DH',
        date: new Date().toISOString().substr(0, 10),
        sourceType: 'client',
        client: '',
        customSource: '',
        status: 'Active',
        frequency: 'One-Time',
        description: ''
      };
      this.errors = {};
    },
    
    formatDate(dateString) {
      const date = new Date(dateString);
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
    },
    
    getClientName(clientId) {
      const client = this.clients.find(c => c.id === parseInt(clientId));
      return client ? client.name : '';
    },
    
    getClientEmail(clientId) {
      const client = this.clients.find(c => c.id === parseInt(clientId));
      return client ? client.email : '';
    }
  }
}
</script>