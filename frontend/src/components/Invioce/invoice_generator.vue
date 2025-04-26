<template>
    <div class="container mx-auto max-w-4xl p-4">
      <h1 class="text-3xl font-bold text-center mb-6">Invoice Creator</h1>
      
      <!-- Tabs -->
      <div class="flex mb-8">
        <button 
          @click="activeTab = 'edit'" 
          class="flex-1 py-3 px-4 text-center rounded-l-md" 
          :class="activeTab === 'edit' ? 'bg-gray-100 font-medium' : 'bg-white'">
          Edit Invoice
        </button>
        <button 
          @click="activeTab = 'preview'" 
          class="flex-1 py-3 px-4 text-center rounded-r-md" 
          :class="activeTab === 'preview' ? 'bg-gray-100 font-medium' : 'bg-white'">
          Preview
        </button>
      </div>
      
      <!-- Edit Mode -->
      <div v-if="activeTab === 'edit'" class="space-y-6">
        <!-- Invoice Details -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h2 class="text-xl font-semibold mb-4 text-center">Invoice Details</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-2">Invoice Number</label>
              <input 
                v-model="invoice.number" 
                type="text" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div></div>
            
            <div>
              <label class="block text-sm font-medium mb-2">Date</label>
              <input 
                v-model="invoice.date" 
                type="date" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-2">Due Date</label>
              <input 
                v-model="invoice.dueDate" 
                type="date" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
          </div>
          
          <div class="flex justify-center my-6">
            <div class="h-24 w-40 border-2 border-dashed border-gray-300 flex items-center justify-center">
              <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span class="text-sm text-gray-500">Logo</span>
              </div>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium mb-2">Company Name</label>
              <input 
                v-model="invoice.from.company" 
                type="text" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-2">Email</label>
              <input 
                v-model="invoice.from.email" 
                type="email" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
            <label class="block text-sm font-medium mb-2">Service Description</label>
            <input 
              v-model="invoice.service_description" 
              type="text" 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2">Service Price</label>
            <input 
              v-model="invoice.service_price" 
              type="number" 
              min="0"
              step="0.01"
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2">Service Name</label>
            <input 
              v-model="invoice.service_name" 
              type="text" 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>
          </div>
        </div>
        
        <!-- Client -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h2 class="text-xl font-semibold mb-4">Client</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
            <label class="block text-sm font-medium mb-2">Select Client</label>
            <select 
              v-model="invoice.to.name"
              type="text" 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
              <option v-for="client in clients" :key="client.id" :value="client.name">{{ client.name }}</option>
            </select>
          </div>
         
          </div>
        </div>
        
    
        <!-- Additional Information -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h2 class="text-xl font-semibold mb-4">Additional Information</h2>
          
          <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Notes</label>
            <textarea 
              v-model="invoice.notes" 
              rows="4" 
              placeholder="Any additional notes for your client..." 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
          </div>
          
          <div>
            <label class="block text-sm font-medium mb-2">Terms & Conditions</label>
            <textarea 
              v-model="invoice.terms" 
              rows="2" 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
          </div>
        </div>
        
        <div class="flex justify-end space-x-4">
          <button class="px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              Print
            </span>
          </button>
          <button @click="sendInvoice()" class="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
              Send Invoice
            </span>
          </button>
        </div>
      </div>
      
      <!-- Preview Mode -->
      <div v-if="activeTab === 'preview'" class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-gray-100 p-8">
          <div class="text-4xl font-bold mb-1">INVOICE</div>
        </div>
        
        <div class="p-8">
          <div class="flex flex-col md:flex-row justify-between mb-8">
            <div class="mb-4 md:mb-0">
              <div class="text-gray-500 mb-1">FROM</div>
              <div class="font-medium">{{ invoice.from.company || 'Your Company' }}</div>
              <div>{{ invoice.from.email || 'your@email.com' }}</div>
            </div>
            
            <div class="mb-4 md:mb-0">
              <div class="text-gray-500 mb-1">BILL TO</div>
              <div class="font-medium">{{ invoice.to.name || 'Client Name' }}</div>
              <div>{{ getClientEmail() || 'client@email.com' }}</div>
            </div>
            
            <div>
              <div class="grid grid-cols-2 gap-x-20 gap-y-2">
                <div class="text-gray-500">INVOICE DATE</div>
                <div class="text-right">{{ invoice.date }}</div>
                
                <div class="text-gray-500">DUE DATE</div>
                <div class="text-right">{{ invoice.dueDate }}</div>
                
                <div class="text-gray-500">AMOUNT DUE</div>
                <div class="text-right">${{ invoice.service_price }}</div>
              </div>
            </div>
          </div>
          
          <table class="w-full mb-8">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2 pl-2">SERVICE NAME</th>
                <th class="text-center py-2">SERVICE DESCRIPTION</th>
                <th class="text-right py-2">SERVICE PRICE</th>
                <th class="text-right py-2 pr-2">AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="py-4 pl-2">{{ invoice.service_name || 'Item description' }}</td>
                <td class="py-4 text-center">{{ invoice.service_description }}</td>
                <td class="py-4 text-right">${{ invoice.service_price }}</td>
                <td class="py-4 text-right pr-2">${{ (invoice.service_price) }}</td>
              </tr>
            </tbody>
          </table>
          
          <div class="border-t pt-8">
            <div class="mb-4">
              <div class="text-gray-600 mb-2">TERMS & CONDITIONS</div>
              <div>{{ invoice.terms || 'Payment due within 30 days' }}</div>
            </div>
            
            <div class="text-center pt-8 text-gray-600">
              Thank you for your business!
            </div>
          </div>
        </div>
        
        <div class="flex justify-end space-x-4 p-6 bg-gray-50">
          <button class="px-6 py-2 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              Print
            </span>
          </button>
          <button class="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
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
    } ,
     data() {
      return {
        activeTab: 'edit',
        invoice: {
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
    props : {
      clients : {
        type : Array,
        required : true,
      }
    },
    computed: {
      totalAmount() {
        return this.invoice.items.reduce((total, item) => {
          return total + (item.quantity * item.unitPrice);
        }, 0);
      }
    },
    methods: {
     async sendInvoice(){
            try {
                const client = this.clients.find(client => client.name === this.invoice.to.name);
                if (!client) {
                    throw new Error('Please select a client');
                }

                const newInvoice = {
                    'total_amount' : this.invoice.service_price,
                    'due_date' : this.invoice.dueDate,
                    'status' : 'draft',
                    'client_id' : client.id,
                    'user_id' : authStore.user.id,
                    'service_name' : this.invoice.service_name,
                    'service_description' : this.invoice.service_description,
                    'service_price' : this.invoice.service_price,
                    'notes' : this.invoice.notes,
                    'terms' : this.invoice.terms
                };
                
                console.log('Creating invoice:', newInvoice);
                const response = await this.invoiceStore.addInvoice(newInvoice);
                console.log('Invoice created successfully:', response);
            } catch (error) {
                console.error('Error creating invoice:', error);
            }
      },
      getClientEmail(){
        const client = this.clients.find(client => client.name === this.invoice.to.name);
        return client.email;
      }
    }
  };
  </script>       