<template>
    <div class="Clients_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Client" />
            <AddBtn name="Add Client"/>
        </div>
        <div class="clients_cards flex flex-wrap justify-evenly gap-4">
            <Client_Card v-for="client in clients"
              :address="client.address"
              :email="client.email"
              :income="client.income"
              :name="client.name"
              :number="client.number"
              :instagram="client.instagram"
              :linkedin="client.linkedin"
              :social="client.social"/>
        </div>
    </div>
</template>

<script>
import Client_Card from '../components/Client.vue/Client_Card.vue';
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';

export default {
    name: 'Clients',
    data(){
        return {
            clients : [
            {
            address: '123 Casablanca St, Morocco',
            email: 'anouar.elbarry@example.com',
            income: 5000,
            name: 'Anouar El Barry',
            number: '+212 663547463',
            instagram: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            linkedin: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            social: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/'
        },
        {
            address: '123 Casablanca St, Morocco',
            email: 'anouar.elbarry@example.com',
            income: 5000,
            name: 'Anouar El Barry',
            number: '+212 663547463',
            instagram: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            linkedin: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            social: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/'
        },
        {
            address: '123 Casablanca St, Morocco',
            email: 'anouar.elbarry@example.com',
            income: 5000,
            name: 'Anouar El Barry',
            number: '+212 663547463',
            instagram: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            linkedin: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            social: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/'
        },
                {
            address: '123 Casablanca St, Morocco',
            email: 'anouar.elbarry@example.com',
            income: 5000,
            name: 'Anouar El Barry',
            number: '+212 663547463',
            instagram: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            linkedin: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/',
            social: 'https://www.linkedin.com/in/anouar-el-barry-39475a254/'
        },
            ]
            
            }
           
    },
    components: {
        AddBtn,
        SearchBare,
        Client_Card
    }
}
</script>