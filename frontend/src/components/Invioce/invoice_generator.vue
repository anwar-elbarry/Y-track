<template>
    <div class="container mx-auto max-w-4xl p-4">
      <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Invoice Creator</h1>
      
      <!-- Tabs -->
      <div class="flex mb-8 bg-white rounded-md shadow-sm overflow-hidden">
        <button 
          @click="activeTab = 'edit'" 
          class="flex-1 py-3 px-4 text-center transition-colors duration-200" 
          :class="activeTab === 'edit' ? 'bg-orange-100 text-orange-800 font-medium' : 'bg-white text-gray-700 hover:bg-gray-50'">
          <span class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Invoice
          </span>
        </button>
        <button 
          @click="activeTab = 'preview'" 
          class="flex-1 py-3 px-4 text-center transition-colors duration-200" 
          :class="activeTab === 'preview' ? 'bg-orange-100 text-orange-800 font-medium' : 'bg-white text-gray-700 hover:bg-gray-50'">
          <span class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Preview
          </span>
        </button>
      </div>
      
      <!-- Edit Mode -->
      <div v-if="activeTab === 'edit'" class="space-y-6">
        <!-- Invoice Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Invoice Details</h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">{{ invoiceStatus }}</span>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Invoice ID</label>
              <div class="flex">
                <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                  #INV-
                </span>
                <input 
                  v-model="invoice.id" 
                  type="text" 
                  class="w-full p-2 border border-gray-300 rounded-r-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none"
                  placeholder="001">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Date</label>
              <input 
                v-model="invoice.date" 
                type="date" 
                disabled
                class="w-full p-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Due Date</label>
              <input 
                v-model="invoice.dueDate" 
                type="date" 
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Company Name Or Your Name</label>
              <input 
                v-model="invoice.from.company" 
                type="text" 
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Email</label>
              <input 
                v-model="invoice.from.email" 
                type="email" 
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
            </div>
          </div>
        </div>
        
        <!-- Client -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">Client Information</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Select Client</label>
              <select 
                v-model="selectedClient"
                @change="updateClientInfo"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
                <option value="">Select a client</option>
                <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.name }}</option>
              </select>
            </div>
            
            <div v-if="selectedClient">
              <label class="block text-sm font-medium mb-2 text-gray-700">Client Email</label>
              <input 
                v-model="invoice.to.email" 
                type="text" 
                readonly
                class="w-full p-2 border border-gray-300 rounded-md bg-gray-50">
            </div>
          </div>
        </div>
        
        <!-- Service Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">Service Details</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Service Name</label>
              <input 
                v-model="invoice.service_name" 
                type="text" 
                placeholder="e.g. Web Development"
                class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-2 text-gray-700">Service Price</label>
              <div class="flex">
                <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                  {{ currency }} 
                </span>
                <input 
                  v-model="invoice.service_price" 
                  type="number" 
                  min="0"
                  step="0.01"
                  class="w-full p-2 border border-gray-300 rounded-r-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none">
              </div>
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-2 text-gray-700">Service Description</label>
            <textarea 
              v-model="invoice.service_description" 
              rows="3" 
              placeholder="Describe the service provided..." 
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none"></textarea>
          </div>
        </div>
    
        <!-- Additional Information -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
          <h2 class="text-xl font-semibold mb-4 text-gray-800">Additional Information</h2>
          
          <div class="mb-4">
            <label class="block text-sm font-medium mb-2 text-gray-700">Notes</label>
            <textarea 
              v-model="invoice.notes" 
              rows="3" 
              placeholder="Any additional notes for your client..." 
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none"></textarea>
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-2 text-gray-700">Terms & Conditions</label>
            <textarea 
              v-model="invoice.terms" 
              rows="2" 
              class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:outline-none"></textarea>
          </div>
        </div>
        
        <div class="flex justify-end space-x-4">
          <button @click="sendInvoice()" class="cursor-pointer px-6 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors duration-200">
            <span class="flex items-center gap-1">
              <v-icon v-if="!issubmitting" name="bi-send"/> 
              <v-icon v-if="issubmitting" name="fa-spinner" animation="spin-pulse" />
              Send Invoice
            </span>
          </button>
        </div>
      </div>
      
      <!-- Preview Mode -->
      <div v-if="activeTab === 'preview'" class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-8 text-white">
          <div class="flex justify-between items-start">
            <div>
              <div class="text-4xl font-bold mb-1">INVOICE</div>
              <div class="text-sm opacity-80">Invoice #INV-{{ invoice.id || '001' }}</div>
            </div>
            <div class="bg-white text-orange-600 px-4 py-2 rounded-md text-sm font-bold">
              {{ invoiceStatus }}
            </div>
          </div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col md:flex-row justify-between mb-8">
            <div class="mb-4 md:mb-0">
              <div class="text-gray-500 text-sm mb-1 uppercase font-medium">FROM</div>
              <div class="font-medium text-lg">{{ invoice.from.company || 'Your Company' }}</div>
              <div class="text-gray-600">{{ invoice.from.email || 'your@email.com' }}</div>
            </div>
            
            <div class="mb-4 md:mb-0">
              <div class="text-gray-500 text-sm mb-1 uppercase font-medium">BILL TO</div>
              <div class="font-medium text-lg">{{ invoice.to.name || 'Client Name' }}</div>
              <div class="text-gray-600">{{ invoice.to.email || 'client@email.com' }}</div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
              <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                <div class="text-gray-500 text-sm">INVOICE DATE</div>
                <div class="text-right font-medium">{{ formatDate(invoice.date) }}</div>
                
                <div class="text-gray-500 text-sm">DUE DATE</div>
                <div class="text-right font-medium">{{ formatDate(invoice.dueDate) }}</div>
                
                <div class="text-gray-500 text-sm">AMOUNT DUE</div>
                <div class="text-right font-medium text-orange-600">{{ currency }} {{ invoice.service_price }}</div>
              </div>
            </div>
          </div>
          
          <div class="overflow-x-auto mb-8">
            <table class="w-full">
              <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                  <th class="text-left py-3 px-4 font-medium text-sm text-gray-600">SERVICE NAME</th>
                  <th class="text-left py-3 px-4 font-medium text-sm text-gray-600">SERVICE DESCRIPTION</th>
                  <th class="text-right py-3 px-4 font-medium text-sm text-gray-600">SERVICE PRICE</th>
                  <th class="text-right py-3 px-4 font-medium text-sm text-gray-600">AMOUNT</th>
                </tr>
              </thead>
              <tbody>
                <tr class="border-b border-gray-200">
                  <td class="py-4 px-4">{{ invoice.service_name || 'Item description' }}</td>
                  <td class="py-4 px-4 text-gray-600">{{ invoice.service_description || 'Service details' }}</td>
                  <td class="py-4 px-4 text-right"> {{ currency }} {{ invoice.service_price }}</td>
                  <td class="py-4 px-4 text-right font-medium"> {{ currency }} {{ invoice.service_price }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr class="bg-gray-50">
                  <td colspan="3" class="py-3 px-4 text-right font-medium">TOTAL:</td>
                  <td class="py-3 px-4 text-right font-bold text-orange-600"> {{ currency }} {{ invoice.service_price }}</td>
                </tr>
              </tfoot>
            </table>
          </div>
          
          <div class="border-t border-gray-200 pt-8">
            <div class="mb-4">
              <div class="text-gray-600 text-sm mb-2 font-medium uppercase">NOTES</div>
              <div class="text-gray-600">{{ invoice.notes || 'No additional notes' }}</div>
            </div>
            
            <div class="mb-8">
              <div class="text-gray-600 text-sm mb-2 font-medium uppercase">TERMS & CONDITIONS</div>
              <div class="text-gray-600">{{ invoice.terms || 'Payment due within 30 days' }}</div>
            </div>
            
            <div class="text-center pt-8 text-gray-600 border-t border-gray-100 mt-8">
              <p class="text-sm">Thank you for your business!</p>
            </div>
          </div>
        </div>
        
        <div class="flex justify-end space-x-4 p-6 bg-gray-50 border-t border-gray-200">
          <button @click="downloadPDF" class="cursor-pointer px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors duration-200">
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
              </svg>
              Download PDF
            </span>
          </button>
          <button @click="sendInvoice()" class="cursor-pointer px-6 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors duration-200">
            <span class="flex items-center gap-1">
             <v-icon v-if="!issubmitting" name="bi-send"/> 
             <v-icon v-if="issubmitting" name="fa-spinner" animation="spin-pulse" />
              Send Invoice
            </span>
          </button>
        </div>
      </div>
    </div>
</template>
  
<script>
import auth from '../../stores/auth';
import { useInvoiceStore } from '../../stores/invoiceStore';
const authStore = auth();

export default {
  name: 'InvoiceGenerator',
  setup(){
    const invoiceStore = useInvoiceStore();
    return {invoiceStore};
  },
  data() {
    return {
      activeTab: 'edit',
      selectedClient: '',
      issubmitting:false,
      currency : authStore.user.currency,
      invoice: {
        id: this.generateInvoiceId(),
        date: new Date().toISOString().slice(0, 10),
        dueDate: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10),
        from: {
          company: authStore.user.name,
          email: authStore.user.email,
        },
        to: {
          name: '',
          email: '',
        },
        service_name: '',
        service_description: '',
        service_price: 0,
        notes: '',
        terms: 'Payment due within 30 days'
      }
    };
  },
  props: {
    clients: {
      type: Array,
      required: true,
    }
  },
  computed: {
    invoiceStatus() {
      return 'DRAFT';
    }
  },
  methods: {
    generateInvoiceId() {
      return Math.floor(Math.random() * 900 + 100).toString();
    },
    formatDate(dateString) {
      if (!dateString) return '';
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    updateClientInfo() {
      if (this.selectedClient) {
        const client = this.clients.find(c => c.id === this.selectedClient);
        if (client) {
          this.invoice.to.name = client.name;
          this.invoice.to.email = client.email;
        }
      } else {
        this.invoice.to.name = '';
        this.invoice.to.email = '';
      }
    },
    downloadPDF() {
      alert('pdf');
    },
    async sendInvoice(){
      try {
        this.issubmitting = true;
        if (!this.invoice.to.name) {
          alert('Please select a client');
          return;
        }

        const client = this.clients.find(client => client.name === this.invoice.to.name);
        if (!client) {
          alert('Please select a valid client');
          return;
        }

        const newInvoice = {
          'total_amount': this.invoice.service_price,
          'due_date': this.invoice.dueDate,
          'status': 'draft',
          'client_id': client.id,
          'user_id': authStore.user.id,
          'service_name': this.invoice.service_name,
          'service_description': this.invoice.service_description,
          'service_price': this.invoice.service_price,
          'notes': this.invoice.notes,
          'terms': this.invoice.terms
        };
        
        console.log('Creating invoice:', newInvoice);
        const response = await this.invoiceStore.addInvoice(newInvoice);
        console.log('Invoice created successfully:', response);
        this.issubmitting = false;
        alert('Invoice sent successfully!');
        
      } catch (error) {
        console.error('Error creating invoice:', error);
        alert('Error sending invoice. Please try again.');
      }
    },
    getClientEmail(){
      const client = this.clients.find(client => client.name === this.invoice.to.name);
      return client ? client.email : '';
    }
  }
};
</script>