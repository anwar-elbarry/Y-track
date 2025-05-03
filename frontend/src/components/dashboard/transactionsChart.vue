<template>
    <div id="expenseVsIncome" class="w-full h-[400px] bg-white rounded-xl shadow-lg p-4"></div>
</template>

<script>
import ApexCharts from 'apexcharts';

export default {
    name: 'TransactionsChart',
    props: {
        transactions: {
            type: Array,
            default: () => []
        },
        currency: {
            type: String,
            default: 'USD'
        }
    },
    data() {
        return {
            chart: null
        }
    },
    methods: {
        initChart() {
            // Group transactions by date and type
            const transactionsByDate = {};
            
            this.transactions.forEach(t => {
                const date = new Date(t.created_at).toISOString().split('T')[0];
                if (!transactionsByDate[date]) {
                    transactionsByDate[date] = { expenses: 0, incomes: 0, bills: 0 };
                }
                transactionsByDate[date][t.type + 's'] += Number(t.amount);
            });

            const dates = Object.keys(transactionsByDate).sort();
            const expenses = dates.map(d => transactionsByDate[d].expenses);
            const incomes = dates.map(d => transactionsByDate[d].incomes);
            const bills = dates.map(d => transactionsByDate[d].bills);

            const options = {
                series: [
                    { name: 'Expenses', data: expenses },
                    { name: 'Incomes', data: incomes },
                    { name: 'Bills', data: bills }
                ],
                chart: { 
                    type: 'bar', 
                    height: 350,
                    stacked: false,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '35%',
                        borderRadius: 5,
                        minHeight: 5 
                    },
                },
                colors: ['#ef4444', '#22c55e', '#3b82f6'],
                xaxis: {
                    categories: dates,
                    labels: { 
                        rotate: -45,
                        formatter: (value) => {
                            return new Date(value).toLocaleDateString();
                        }
                    }
                },
                yaxis: { 
                    title: { text: `Amount (${this.currency})` },
                    min: 0,
                    forceNiceScale: true,
                    labels: {
                        formatter: (value) => {
                            return value.toFixed(2);
                        }
                    }
                },
                tooltip: { 
                    y: { 
                        formatter: val => `${val.toFixed(2)} ${this.currency}`
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    position: 'top'
                }
            };

            if (this.chart) this.chart.destroy();
            this.chart = new ApexCharts(document.querySelector("#expenseVsIncome"), options);
            this.chart.render();
        }
    },
    watch: {
        transactions: {
            handler: 'initChart',
            deep: true
        },
        currency: 'initChart'
    },
    mounted() {
        this.initChart();
    },
    beforeUnmount() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}
</script>