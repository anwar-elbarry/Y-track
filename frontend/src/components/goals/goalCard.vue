<template>
    <div class="border border-gray-100 shadow-md bg-white p-6 rounded-xl min-w-2xs max-h-60">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-gray-900 text-xl font-semibold">
                    {{ title }}
                </h3>
                <div class="text-gray-600 mt-4">
                    Target: {{ target }}
                </div>
                <div class="flex items-center gap-2 mt-3">
                    <img
                        src="#"
                        class="w-4 h-4"
                        alt="Calendar icon"
                    />
                    <span class="text-gray-500 text-sm">
                        {{ daysRemaining }} days remaining
                    </span>
                </div>
            </div>
            <img
                :src="iconSrc"
                class="w-10 h-10"
                alt="Goal icon"
            />
        </div>
        <div class="mt-6">
            <div class="bg-gray-200 rounded-full h-2">
                <div 
                    class="bg-slate-500 h-2 rounded-full" 
                    :style="{ width: `${percentage}%` }"
                />
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="text-gray-600">{{ saved }} saved</span>
                <span class="text-emerald-600">{{ percentage }}%</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GoalCard',
    props: {
        title: {
            type: String,
            required: true
        },
        target: {
            type: Number,
            required: true
        },
        daysRemaining: {
            type: Number,
            required: true
        },
        iconSrc: {
            type: String,
            default: '/path/to/default-icon.svg'
        },
        saved: {
            type: Number,
            required: true
        },
        percentage: {
            type: Number,
            required: true
        }
    }
}
</script>