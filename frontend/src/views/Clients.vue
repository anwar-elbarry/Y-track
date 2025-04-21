<template>
    <div class="Clients_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Client" />
            <AddBtn @click="openForm()" name="Add Client"/>
        </div>
        <div class="clients_cards flex flex-wrap justify-evenly gap-4">
            <Client_Card v-for="client in clients"
              :address="client.address"
              :email="client.email"
              :income="client.income"
              :name="client.name"
              :phone="client.phone"
              :instagram="client.instagram"
              :linkedin="client.linkedin"
              :social="client.social"/>
        </div>
        <Client_form  
        v-if="isOpen"
        @close="closeForm"
        @client-added="fetchClients"
        />
    </div>
</template>

<script>
import Client_Card from '../components/Client.vue/Client_Card.vue';
import Client_form from '../components/Client.vue/Client_form.vue';
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import { useClientStore } from '../stores/clientStore';

export default {
    name: 'Clients',
    data(){
        return {
            clients : [],
            isOpen : false,
            }
    },
    setup(){
        const clientStore = useClientStore();
        return {clientStore};
     },
    components: {
        AddBtn,
        SearchBare,
        Client_Card,
        Client_form
    },
    methods : {
        openForm(){
            this.isOpen = true;
        },
        closeForm(){
            this.isOpen = false;
        },
       async fetchClients(){
            await this.clientStore.fetchClients();
            this.clients = this.clientStore.clients;
        }
    },
    created(){
        this.fetchClients();
    }
}
</script>