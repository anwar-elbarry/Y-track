<template>
    
    <div class="w-40 h-26 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 flex flex-col p-5">
    <div class="flex items-center gap-3 text-gray-600 mb-4">
        <v-icon :name="icon" class="text-xl" />
        <span class="text-sm font-medium">{{ title }}</span>
    </div>
    <div class="flex items-center justify-center gap-2" >
        <p class="text-l font-bold text-gray-800">
        {{ value }}
    </p>
    <p v-if="title != 'Clients'" class="text-xs font-bold text-gray-400">
        {{ currency }}
    </p></div>  
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
        default: 'income'
    },
    icon : {
        type: String,
        default: 'md-accountbalancewallet'
    },
    currency : {
        type : String,
        default : "MAD"
    }
}
}

</script>