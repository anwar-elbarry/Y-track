<template>
    <div class="tax_container w-full h-full gap-4">
        <TaxRecords />
    </div>
</template>

<script>


import TaxRecords from '../components/Tax/TaxRecords.vue';

export default {
    name: 'Taxes',
    components: {
        TaxRecords
    },
}
</script>