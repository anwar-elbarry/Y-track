<template>
    
    <div class="w-64 h-32 bg-white rounded-lg shadow-md border border-gray-200 flex flex-col p-4 relative">
            <div class="flex items-center  text-gray-500 mb-4">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 100-12 6 6 0 000 12z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-lg">{{ title }}</span>
            </div>
            <div class="text-3xl font-bold text-black">
                {{ formattedValue }}
            </div>
    </div>
</template>

<script>

export default {
name: 'Dash_card',
props: {
    value: {
        type: Number,
        default: 50800
    },
    title : {
        type: String,
        default: 'Net Income'
    }
},
computed: {
    formattedValue() {
        return this.value >= 1000
            ? `${(this.value / 1000).toFixed(1)}K`
            : this.value.toString();
    }
}
}

</script>