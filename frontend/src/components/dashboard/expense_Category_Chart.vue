<template>
    <div class="w-1/2 h-[400px] bg-white rounded-xl shadow-lg p-4">
        <div v-if="!hasData" class="flex items-center justify-center h-full text-gray-500">
            No data available
        </div>
        <div v-else id="categoryChart" class="w-full h-full"></div>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    name: 'categoryChart',
    props: {
        expensecategories: {
            type: Array,
            default: () => []
        },
        currency: {
            type: String,
            default: 'DH'
        }
    },
    data() {
        return {
            chart: null
        }
    },
    computed: {
        hasData() {
            return this.expensecategories.some(cat => cat.total_amount > 0);
        },
        chartData() {
            const validCategories = this.expensecategories.filter(cat => cat.total_amount > 0);
            return {
                labels: validCategories.map(cat => cat.name),
                series: validCategories.map(cat => Number(cat.total_amount))
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
                const chartElement = document.querySelector("#categoryChart");
                if (!chartElement) {
                    console.error("Chart element not found");
                    return;
                }

                const options = {
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    chart: {
                        type: 'donut',
                        height: 350,
                        animations: {
                            enabled: true,
                            speed: 500
                        }
                    },
                    colors: ['#ef4444', '#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6', '#ec4899'],
                    plotOptions: {
                        pie: {
                            donut: { 
                                size: '70%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true
                                    },
                                    value: {
                                        show: true,
                                        formatter: (val) => `${val} ${this.currency}`
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        formatter: (w) => {
                                            const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            return `${total} ${this.currency}`;
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val, opts) => {
                            const amount = this.chartData.series[opts.seriesIndex];
                            return `${amount} ${this.currency}`;
                        }
                    },
                    legend: {
                        position: 'bottom',
                        formatter: (label, opts) => {
                            const amount = this.chartData.series[opts.seriesIndex];
                            return `${label}: ${amount} ${this.currency}`;
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    title: {
                        text: 'Expense Categories',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold'
                        }
                    }
                };

                try {
                    this.chart = new ApexCharts(chartElement, options);
                    this.chart.render();
                } catch (error) {
                    console.error("Failed to initialize chart:", error);
                }
            });
        }
    },
    watch: {
        expensecategories: {
            handler: 'initChart',
            deep: true
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
