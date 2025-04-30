<template>
    <div id="expenseVsIncome" class="w-full h-[400px] bg-white rounded-xl shadow-lg p-4">
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    name: 'charts',
    props: {
        transactions: {
            type: Array,
            default: () => []
        },
        currency : {
            type : String,
            default : 'USD'
        }
    },
    data() {
        return {
            chart: null,
            chartOptions: {
                series: [{
                    name: 'Expenses',
                    data: []
                }, {
                    name: 'Incomes',
                    data: []
                },
                {
                    name: 'Bills',
                    data: []
                }
            ],
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: true
                    },
                    background: 'transparent'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '65%',
                        endingShape: 'rounded',
                        borderRadius: 4
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => {
                        return `${val} ${this.currency}`
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ['#ef4444', '#22c55e', '#3b82f6'],
                xaxis: {
                    type: 'datetime',
                    categories: [],
                    labels: {
                        rotate: -45,
                        rotateAlways: true,
                        formatter: (value) => {
                            return new Date(value).toLocaleDateString()
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: `Amount (${this.currency})`
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => {
                            return `${val} ${this.currency}`
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            }
        }
    },
    methods: {
        initChart() {
            this.chart = new ApexCharts(document.querySelector("#expenseVsIncome"), this.chartOptions);
            this.chart.render();
        },
        updateChartData() {
            if (!this.transactions.length) return;
            
            // Sort transactions by date
            const sortedTransactions = [...this.transactions].sort((a, b) => 
                new Date(a.created_at) - new Date(b.created_at)
            );

            // unique dates
            const dates = [...new Set(sortedTransactions.map(t => 
                new Date(t.created_at).toISOString()
            ))];

            
            const expensesData = [];
            const incomesData = [];
            const billsData = [];

            dates.forEach(date => {
                const dayTransactions = sortedTransactions.filter(t => 
                    new Date(t.created_at).toISOString().split('T')[0] === date.split('T')[0]
                );
                
                const expenses = dayTransactions
                    .filter(t => t.type === 'expense')
                    .reduce((sum, t) => sum + t.amount, 0);
                    
                const incomes = dayTransactions
                    .filter(t => t.type === 'income')
                    .reduce((sum, t) => sum + t.amount, 0);
                const bills = dayTransactions
                    .filter(t => t.type === 'bill')
                    .reduce((sum, t) => sum + t.amount, 0);

                expensesData.push(expenses);
                incomesData.push(incomes);
                billsData.push(bills);
            });

         
            this.chartOptions.xaxis.categories = dates;
            this.chartOptions.series[0].data = expensesData;
            this.chartOptions.series[1].data = incomesData;
            this.chartOptions.series[2].data = billsData;

            if (this.chart) {
                this.chart.updateOptions(this.chartOptions);
            }
        }
    },
    watch: {
        transactions: {
            handler: 'updateChartData',
            immediate: true
        }
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