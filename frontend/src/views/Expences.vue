<template>
    <div class="Expences_container flex flex-col w-full h-full gap-4">
        <div class="up_content w-full justify-end items-center flex gap-5">
            <SearchBare title="Expence" />
            <AddBtn name="Add Expence"/>
        </div>
        <Expence_table />
    </div>
</template>

<script>
import AddBtn from '../components/dashboard/addBtn.vue';
import SearchBare from '../components/dashboard/searchBare.vue';
import Expence_table from '../components/expences/expence_table.vue';

export default {
    name: 'Expences',
    components: {
        AddBtn,
        SearchBare,
        Expence_table
    }
}
</script>