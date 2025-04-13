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
          </div>
        </div>
        
        <!-- Client -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <h2 class="text-xl font-semibold mb-4">Client</h2>
          
          <div>
            <label class="block text-sm font-medium mb-2">Select Client</label>
            <input 
              v-model="invoice.to.name" 
              type="text" 
              class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          </div>
        </div>
        
        <!-- Invoice Items -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Invoice Items</h2>
            <button 
              @click="addItem" 
              class="bg-white border border-gray-300 rounded-md p-2 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <span class="font-medium text-sm">+</span> Add Item
            </button>
          </div>
          
          <div 
            v-for="(item, index) in invoice.items" 
            :key="index" 
            class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-5">
              <label v-if="index === 0" class="block text-sm font-medium mb-2">Description</label>
              <input 
                v-model="item.description" 
                type="text" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div class="col-span-2">
              <label v-if="index === 0" class="block text-sm font-medium mb-2">Quantity</label>
              <input 
                v-model.number="item.quantity" 
                type="number" 
                min="1" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div class="col-span-3">
              <label v-if="index === 0" class="block text-sm font-medium mb-2">Unit Price</label>
              <input 
                v-model.number="item.unitPrice" 
                type="number" 
                min="0" 
                step="0.01" 
                class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            
            <div class="col-span-1">
              <label v-if="index === 0" class="block text-sm font-medium mb-2">&nbsp;</label>
              <button 
                @click="removeItem(index)" 
                class="p-2 text-red-500 hover:text-red-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          </div>
          
          <div class="text-right pt-4 border-t">
            <p class="font-medium">Total: ${{ totalAmount.toFixed(2) }}</p>
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
      
      <!-- Preview Mode -->
      <div v-if="activeTab === 'preview'" class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-gray-100 p-8">
          <div class="text-4xl font-bold mb-1">INVOICE</div>
          <div class="text-gray-600">#{{ invoice.number }}</div>
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
            </div>
            
            <div>
              <div class="grid grid-cols-2 gap-x-20 gap-y-2">
                <div class="text-gray-500">INVOICE DATE</div>
                <div class="text-right">{{ formatDate(invoice.date) }}</div>
                
                <div class="text-gray-500">DUE DATE</div>
                <div class="text-right">{{ formatDate(invoice.dueDate) }}</div>
                
                <div class="text-gray-500">AMOUNT DUE</div>
                <div class="text-right">${{ totalAmount.toFixed(2) }}</div>
              </div>
            </div>
          </div>
          
          <table class="w-full mb-8">
            <thead>
              <tr class="border-b">
                <th class="text-left py-2 pl-2">DESCRIPTION</th>
                <th class="text-center py-2">QUANTITY</th>
                <th class="text-right py-2">UNIT PRICE</th>
                <th class="text-right py-2 pr-2">AMOUNT</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in invoice.items" :key="index" class="border-b">
                <td class="py-4 pl-2">{{ item.description || 'Item description' }}</td>
                <td class="py-4 text-center">{{ item.quantity }}</td>
                <td class="py-4 text-right">${{ item.unitPrice.toFixed(2) }}</td>
                <td class="py-4 text-right pr-2">${{ (item.unitPrice * item.quantity).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
          
          <div class="flex justify-end mb-8">
            <div class="w-80">
              <div class="flex justify-between py-2">
                <div class="text-gray-600">Subtotal:</div>
                <div>${{ totalAmount.toFixed(2) }}</div>
              </div>
              <div class="flex justify-between py-2">
                <div class="text-gray-600">Tax (0%):</div>
                <div>$0.00</div>
              </div>
              <div class="flex justify-between py-2 font-medium">
                <div>Total:</div>
                <div>${{ totalAmount.toFixed(2) }}</div>
              </div>
            </div>
          </div>
          
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
  export default {
    name: 'InvoiceGenerator',
    data() {
      return {
        activeTab: 'edit',
        invoice: {
          number: 'INV-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.floor(Math.random() * 1000),
          date: new Date().toISOString().slice(0, 10),
          dueDate: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().slice(0, 10),
          from: {
            company: '',
            email: ''
          },
          to: {
            name: ''
          },
          items: [
            {
              description: '',
              quantity: 1,
              unitPrice: 0
            }
          ],
          notes: '',
          terms: 'Payment due within 30 days'
        }
      };
    },
    computed: {
      totalAmount() {
        return this.invoice.items.reduce((total, item) => {
          return total + (item.quantity * item.unitPrice);
        }, 0);
      }
    },
    methods: {
      addItem() {
        this.invoice.items.push({
          description: '',
          quantity: 1,
          unitPrice: 0
        });
      },
      removeItem(index) {
        if (this.invoice.items.length > 1) {
          this.invoice.items.splice(index, 1);
        }
      },
      formatDate(dateString) {
        if (!dateString) return '';
        
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
      }
    }
  };
  </script>