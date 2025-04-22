<template>
    <div class="fixed inset-0 bg-gray-800/50 backdrop-blur-xl z-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            Add New Client
          </h2>
        
          <form @submit.prevent="validateAndSubmit" class="space-y-5">
            
            
            <!-- name -->
            <div class="transition-all duration-300">
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name*</label>
              <input 
                type="text" 
                id="name" 
                v-model="form.name" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="Anouar"
                :class="{'border-red-500': errors.name}"
              />
              <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
            </div>
            <!-- email -->
            <div class="transition-all duration-300">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input 
                type="email"
                id="email" 
                v-model="form.email" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="Ytrack@gmail.com"
                :class="{'border-red-500': errors.email}"
              />
              <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
            </div>
            <!-- phone number -->
            <div class="transition-all duration-300">
              <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
              <input 
                type="text" 
                id="phone" 
                v-model="form.phone" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="0777777777"
                :class="{'border-red-500': errors.phone}"
              />
              <p v-if="errors.phone" class="mt-1 text-sm text-red-600">{{ errors.phone }}</p>
            </div>
            <!-- linkedin -->
            <div class="transition-all duration-300">
              <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-1">Linkedin</label>
              <input 
              type="url" 
                id="linkedin" 
                v-model="form.linkedin" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="https://www.linkedin.com/in/Y-track/"
                :class="{'border-red-500': errors.linkedin}"
              />
              <p v-if="errors.linkedin" class="mt-1 text-sm text-red-600">{{ errors.linkedin }}</p>
            </div>
            <!-- instagram -->
            <div class="transition-all duration-300">
              <label for="instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
              <input 
              type="url" 
                id="instagram" 
                v-model="form.instagram" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="https://www.instagram.com/Y-track/"
                :class="{'border-red-500': errors.instagram}"
              />
              <p v-if="errors.instagram" class="mt-1 text-sm text-red-600">{{ errors.instagram }}</p>
            </div>
            <!-- other website -->
            <div class="transition-all duration-300">
              <label for="other_website" class="block text-sm font-medium text-gray-700 mb-1">Other Website</label>
              <input 
                type="url" 
                id="other_website" 
                v-model="form.other_website" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                placeholder="https://www.Y-track.com/"
                :class="{'border-red-500': errors.other_website}"
              />
              <p v-if="errors.linkedin" class="mt-1 text-sm text-red-600">{{ errors.linkedin }}</p>
            </div>
            <!-- address -->
            <div>
              <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Country*</label>
              <div class="relative">
                <select 
                  id="address" 
                  v-model="form.address" 
                  class="block w-full pl-12 pr-4 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500"
                  :class="{'border-red-500': errors.address}"
                >
                  <option value="" disabled selected>Select a country</option>
                  <option 
                    v-for="country in countries" 
                    :key="country.name" 
                    :value="country.name"
                    class="flex items-center gap-2"
                  >
                    <div class="flex items-center gap-2">
                      <img 
                        :src="country.flag" 
                        :alt="country.name"
                        class="w-6 h-4 inline-block mr-2"
                      />
                      {{ country.name }}
                    </div>
                  </option>
                </select>

                <!-- Show selected country flag -->
                <div v-if="form.address" class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img 
                    :src="getSelectedCountryFlag" 
                    :alt="form.address"
                    class="w-6 h-4 object-cover"
                  />
                </div>

                <!-- Dropdown arrow -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <p v-if="errors.address" class="mt-1 text-sm text-red-600">{{ errors.address }}</p>
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
              >
                <svg v-if="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Add Client
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useClientStore } from '../../stores/clientStore';
  
  export default {
    name: 'clientForm',
    emits: ['client-added', 'close'],
    setup() {
      const clientStore = useClientStore()
      return { clientStore }
    },
    data() {
      return {
        isSubmitting: false,
        errors: {},
        countries: [],
        form: {
          name: '',
          email: '',
          phone: '',
          address: '',
          linkedin: null,
          instagram: null,
          other_website: null,
        },
      }
    },
    computed: {
      getSelectedCountryFlag() {
        const country = this.countries.find(c => c.name === this.form.address)
        return country ? country.flag : ''
      }
    },
    methods: {
      async validateAndSubmit() {
        // Reset errors
        this.errors = {};
        
        // Validate name
        if (!this.form.name) {
          this.errors.name = 'Please select a name';
        }
        
        // Validate email
        if (!this.form.email) {
          this.errors.email = 'Please select a Email';
        }
        
        // Validate Phone
        if (!this.form.phone) {
          this.errors.phone = 'Please select a Phone Number';
        }
        
        // Validate address
        if (!this.form.address) {
          this.errors.address = 'Please select a country';
        }
        
        if (Object.keys(this.errors).length > 0) {
          return;
        }
        
        const newClient = {
          name: this.form.name,
          email: this.form.email,
          phone: this.form.phone,
          address: this.form.address,
          linkedin: this.form.linkedin,
          instagram: this.form.instagram,
          other_website: this.form.other_website
        };
      
        console.log('New income entry:', newClient);
        try{
          this.isSubmitting = true;
          await this.clientStore.addclient(newClient);
          
          // Reset the form 
          this.resetForm();
          this.$emit('client-added');
          this.$emit('close');
          this.isSubmitting = false;
        }catch(error){
          console.error('error create new clinet',error);
        }
      },
      resetForm() {
        this.form = {
          name: '',
          email: '',
          phone: '',
          address: '',
          linkedin: null,
          instagram: null,
          other_website: null,
        };
        this.errors = {};
      },
      async getcountries() {
        try {
          const response = await axios.get('https://countriesnow.space/api/v0.1/countries/flag/images')
          this.countries = response.data.data.map(item => ({
            name: item.name,
            flag: item.flag,
          }))
          console.log('Countries loaded:', this.countries)
        } catch (error) {
          console.error('Error fetching countries:', error)
          this.errors.address = 'Failed to load countries'
        }
      }
    },
    created(){
      this.getcountries();
    }
  }
  </script>