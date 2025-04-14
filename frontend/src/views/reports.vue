<template>
    <div class="reports_container w-full h-full gap-4 flex flex-wrap justify-evenly">
        <Report_card 
            v-for="report in reports" 
            :key="report.id"
            :title="report.title"
            :description="report.description"
            :date="report.date"
            :icon="report.icon"
        />
    </div>
</template>

<script>

import Report_card from '../components/reports/report_card.vue';

export default {
    name: 'Reports',
    components: {
        Report_card
    },
    data() {
        return {
            reports: [
                {
                    id: 1,
                    title: 'Monthly Income Report',
                    description: 'Detailed breakdown of income sources',
                    date: '2024-04-01',
                    icon: '/icons/income-report.svg'
                },
                {
                    id: 2,
                    title: 'Expense Analysis',
                    description: 'Comprehensive expense tracking',
                    date: '2024-04-10',
                    icon: '/icons/expense-report.svg'
                },
                {
                    id: 3,
                    title: 'Tax Projection',
                    description: 'Estimated tax liabilities',
                    date: '2024-04-15',
                    icon: '/icons/tax-report.svg'
                },
                {
                    id: 4,
                    title: 'Investment Performance',
                    description: 'Quarterly investment review',
                    date: '2024-04-20',
                    icon: '/icons/investment-report.svg'
                }
            ]
        }
    }
}
</script>