<template>
    
    <div class="w-54 h-32 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 flex flex-col p-5">
    <div class="flex items-center gap-3 text-gray-600 mb-4">
        <v-icon :name="icon" class="text-xl" />
        <span class="text-lg font-medium">{{ title }}</span>
    </div>
    <p class="text-2xl font-bold text-gray-800">
        {{ value }}
    </p>
</div>
</template>

<script>

export default {
name: 'Dash_card',
props: {
    value: {
        type: Number,
        default: 0
    },
    title : {
        type: String,
        default: 'md-accountbalancewallet'
    },
    icon : {
        type: String,
        default: 'Net Income'
    }
}
}

</script>