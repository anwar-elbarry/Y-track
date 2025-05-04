<template>
    <div class="w-full min-h-[400px] bg-white rounded-xl shadow-lg p-4">
        <div v-if="!hasData" class="flex items-center justify-center h-full text-gray-500">
            No transactions available
        </div>
        <div v-else ref="chartContainer" class="w-full h-full"></div>
    </div>
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
    computed: {
        hasData() {
            return this.transactions.length > 0;
        },
        chartData() {
         
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

            return {
                series: [
                    { name: 'Expenses', data: expenses },
                    { name: 'Incomes', data: incomes },
                    { name: 'Bills', data: bills }
                ],
                dates
            };
        }
    },
    methods: {
        initChart() {
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }

            if (!this.hasData) return;

            this.$nextTick(() => {
                const chartElement = this.$refs.chartContainer;
                if (!chartElement) {
                    console.error("Chart element not found");
                    return;
                }

                const options = {
                    series: this.chartData.series,
                    chart: {
                        type: 'bar',
                        height: '100%',
                        width: '100%',
                        toolbar: {
                            show: true
                        },
                        animations: {
                            enabled: true,
                            speed: 500
                        },
                        redrawOnWindowResize: true,
                        redrawOnParentResize: true,
                        zoom: {
                            enabled: false
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
                        categories: this.chartData.dates.map(date => new Date(date).toLocaleDateString()),
                        labels: { 
                            rotate: -45,
                            formatter: (value) => value
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

                this.chart = new ApexCharts(chartElement, options);
                this.chart.render();
            });
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