<template>
    <div class="flex justify-center items-center bg-gray-50">
      <div class="w-64 bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Profile Card -->
        <div class="p-5">
          <!-- Top Section with Profile Image and Icons -->
          <div class="flex justify-between mb-4">
            <!-- Profile Image -->
            <v-icon @click="removeClient(id)" name="oi-trash" class="cursor-pointer hover:text-red-500 mr-2"/>
            <div class="relative w-3/2 h-24 flex justify-center items-center">
              <img class="rounded-full" :src="`https://ui-avatars.com/api/?name=${ name }&background=random&color=fff`" :alt="name">            
            </div>
            
            <!-- Icons Column -->
            <div class="flex flex-col space-y-2">
             
                <a v-if="instagram" :href="instagram" target="_blank" rel="noopener noreferrer"><v-icon name="bi-instagram" /></a> 
              
                <a v-if="linkedin" :href="linkedin" target="_blank" rel="noopener noreferrer"><v-icon name="bi-linkedin" /></a> 
              
                <a v-if="other_website" :href="other_website" target="_blank" rel="noopener noreferrer"><v-icon name="fa-globe" /></a> 
            
            </div>
          </div>
          
          <!-- Name -->
          <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-800">{{name}}</h2>
          </div>
          
          <!-- Contact Info -->
          <div class="space-y-2">
            <!-- Phone Number -->
            <div class="flex items-center text-sm text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              {{phone}}
            </div>
            
            <!-- Address -->
            <div class="flex items-center text-sm text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              {{ address }}
            </div>
          </div>
        </div>
        
        <!-- Income Section -->
        <div class="border-t border-gray-100 p-4">
          <div class="text-xs text-gray-400 uppercase text-center mb-1">
            LINKED INCOME
          </div>
          <div class="text-center text-green-500 font-semibold">
            {{ incomes }} DH
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useClientStore } from '../../stores/clientStore';
  export default {
    name: 'Client_Card',
    data(){
        return {
            currency : 'DH'
        }
    },
    setup(){
      const clientStore = useClientStore();
      return {clientStore}
    },
    emits : ['remove-client'],
        props : {
        id : {
            type : Number,
            required: true
        },
        name : {
            type : String,
            default : 'Anouar el barry',
            required: true
        },
        email : {
            type : String,
            default : 'ellbarryanouar@gmail.come',
            required: true
        },
        phone : {
            type : String,
            default : '+212 663547463',
            required: true
        },
        address : {
            type : String,
            default : 'morocco',
            required: true
        },
        instagram : {
            type : String,
            default : 'morocco',
            required: true
        },
        linkedin : {
            type : String,
            default : 'morocco',
            required: true
        },
        other_website : {
            type : String,
            default : 'morocco',
            required: true
        },
        incomes : {
            type : Array,
            default : [],
            required: true
        },
    },
    methods : {
        async removeClient(id){
        try{
          this.$emit('remove-client', id);
        }catch(error){
          console.error('Error removing client:', error);
        }
      },
    }
  }
  </script>