<template>
    <div class="flex-1 min-w-[300px] h-[400px] bg-white rounded-xl shadow-lg p-4">
        <div v-if="!hasData" class="flex items-center justify-center h-full text-gray-500">
            No bills available
        </div>
        <div v-else ref="chartContainer" class="w-full h-full"></div>
    </div>
</template>

<script>
import ApexCharts from 'apexcharts'

export default {
    name: 'bills_category_chart',
    props: {
        billscategories: {
            type: Array,
            default: () => []
        },
        currency: {
            type: String,
            default: 'MAD'
        }
    },
    data() {
        return {
            chart: null
        }
    },
    computed: {
        hasData() {
            return this.billscategories && this.billscategories.some(cat => cat.bills && cat.bills.length > 0);
        },
        chartData() {
            if (!this.billscategories) return { labels: [], series: [] };
            
            const validCategories = this.billscategories.filter(cat => cat.bills && cat.bills.length > 0);
            return {
                labels: validCategories.map(cat => cat.name),
                series: validCategories.map(cat => {
                    return cat.bills.reduce((sum, bill) => sum + Number(bill.amount), 0);
                })
            };
        }
    },
    methods: {
        initChart() {
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }

            if (!this.hasData) {
                console.log('No valid data for chart', this.billscategories);
                return;
            }

            this.$nextTick(() => {
                const chartElement = this.$refs.chartContainer;
                if (!chartElement) {
                    console.error("Chart element not found");
                    return;
                }

                const options = {
                    series: this.chartData.series,
                    labels: this.chartData.labels,
                    chart: {
                        type: 'donut',
                        height: '100%',
                        width: '100%',
                        animations: {
                            enabled: true,
                            speed: 500
                        },
                        redrawOnWindowResize: true,
                        redrawOnParentResize: true
                    },
                    colors: ['#0ea5e9', '#6366f1', '#14b8a6', '#a855f7', '#f43f5e', '#f97316'],
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
                                        formatter: (val) => `${val.toFixed(2)} ${this.currency}`
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total Bills',
                                        formatter: (w) => {
                                            const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            return `${total.toFixed(2)} ${this.currency}`;
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
                            return `${amount.toFixed(2)} ${this.currency}`;
                        }
                    },
                    legend: {
                        position: 'bottom',
                        formatter: (label, opts) => {
                            const amount = this.chartData.series[opts.seriesIndex];
                            return `${label}: ${amount.toFixed(2)} ${this.currency}`;
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: (val) => `${val.toFixed(2)} ${this.currency}`
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    title: {
                        text: 'Bills Categories',
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
        billscategories: {
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
