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
              :other_website="client.other_website"
              :incomes="client.linked_incomes"
              :id="client.id"
              @remove-client="removeClientFromList"
              />
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
        },
        async removeClientFromList(clientId) {
            try {
                await this.clientStore.removeclient(clientId);
                this.clients = this.clients.filter(client => client.id !== clientId);
            } catch(error) {
                console.error('Error removing client:', error);
            }
        }
    },
    created(){
        this.fetchClients();
    }
}
</script>