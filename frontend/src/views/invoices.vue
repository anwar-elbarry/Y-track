<template>
    <div class="Invoice_container flex flex-col w-full h-full gap-4">
    
        <Invoice_generator />
         
    </div>
</template>

<script>

import Invoice_generator from '../components/Invioce/invoice_generator.vue';

export default {
    name: 'Invoice',
    components: {
        Invoice_generator
    },
}
</script>