<template>
    <div class="border border-gray-100 shadow-md bg-white p-6 rounded-xl min-w-2xs max-h-60 hover:shadow-2xl">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-gray-900 text-xl font-semibold">
                    {{ title }}
                </h3>
                <div class="flex items-center gap-2 mt-4">
                    <v-icon name="gi-archery-target" class="text-black"/>
                    <p class="text-gray-500">Target: {{ target }} {{ currency }}</p> 
                </div>
                <div class="flex items-center gap-2 mt-3">
                    <v-icon name="md-timer-outlined" />
                    <span class="text-gray-500 text-sm">
                      {{ daysRemaining === 'Overdue' ? 'Deadline passed' : 
                         daysRemaining === 'Due today' ? 'Due today' : 
                         daysRemaining === 'Due tomorrow' ? 'Due tomorrow' : 
                         `${daysRemaining}` }}
                    </span>
                </div>
            </div>
            <v-icon name="oi-trash" class="cursor-pointer hover:text-red-500"/>
            <v-icon @click="sendUpdateGoal(id)" name="la-edit-solid" class="cursor-pointer hover:text-green-500"/>
        </div>
        <div class="mt-6">
            <div class="bg-gray-200 rounded-full h-2">
                <div 
                    class="bg-slate-500 h-2 rounded-full" 
                    :style="{ width: `${percentage}%` }"   />
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="text-gray-600">{{ saved }} saved</span>
                <span class="text-emerald-600">{{ percentage }}%</span>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '../../stores/auth';
const authStore = auth();
export default {
    name: 'GoalCard',
    emits : ['goal-to-update'],
    props: {
        id: {
            type: Number,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        target: {
            type: Number,
            required: true
        },
        daysRemaining: {
            type: String,
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
            default: 23,
            required: true
        }
    },
    data(){
        return {
            currency : authStore.user.currency
        }
    },
    methods : {
        sendUpdateGoal(id){
            this.$emit('goal-to-update',id);
        }
    }
}
</script>