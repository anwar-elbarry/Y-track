<template>
    <div class="Invoice_container flex flex-col w-full h-full gap-4">
    
        <Invoice_generator
        :clients="clients" />
         
    </div>
</template>

<script>

import Invoice_generator from '../components/Invioce/invoice_generator.vue';
import { useClientStore } from '../stores/clientStore';
export default {
    name: 'Invoice',
    components: {
        Invoice_generator
    },
    setup(){
        const clientStore = useClientStore();
        return {clientStore};
    },
    data(){
       return {
        clients : [],
       } 
    },
    methods :{
       async fetchClients(){
           await this.clientStore.fetchClients();
           this.clients = this.clientStore.clients;
           console.log(this.clients);
           
        }
    },
    created(){
        this.fetchClients();
    }
}
</script>