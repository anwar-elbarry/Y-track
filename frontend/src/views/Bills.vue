<template>
    <div class="Billss_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Bills" />
            <AddBtn name="Add Bills" @click="showForm = true"/>
        </div>
        
        <Bills_table />
    </div>
</template>

<script>
import Bills_table from '../components/Bills/Bills_table.vue';
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';

export default {
    name: 'Billss',
    components: {
        AddBtn,
        SearchBare,
        Bills_table
    }
}
</script>