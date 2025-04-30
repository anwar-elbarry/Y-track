<template>
    <div id="categoryChart" class="w-full h-[400px] bg-white rounded-xl shadow-lg p-4">
        <div v-if="!expensecategories.length" class="flex items-center justify-center h-full text-gray-500">
            No data available
        </div>
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
            chart: null,
            chartOptions: {
                series: [],
                labels: [],
                chart: {
                    type: 'donut',
                    height: 350,
                    toolbar: {
                        show: true
                    },
                    background: 'transparent'
                },
                colors: [
                    '#ef4444', // Red
                    '#3b82f6', // Blue
                    '#22c55e', // Green
                    '#f59e0b', // Yellow
                    '#8b5cf6', // Purple
                    '#ec4899', // Pink
                    '#64748b', // Slate
                ],
                legend: {
                    position: 'bottom',
                    formatter: function(seriesName, opts) {
                        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val, opts) => {
                        const amount = opts.w.globals.series[opts.seriesIndex]
                        return `${opts.w.config.labels[opts.seriesIndex]}\n${amount} ${this.currency}`
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => {
                            return `${val} ${this.currency}`
                        }
                    }
                },
                title: {
                    text: 'Expense Categories',
                    align: 'center',
                    style: {
                        fontSize: '16px',
                        fontWeight: 'bold'
                    }
                }
            }
        }
    },
    methods: {
        initChart() {
            if (this.chart) {
                this.chart.destroy();
            }
            console.log('Initializing chart with data:', {
                labels: this.chartOptions.labels,
                series: this.chartOptions.series
            });
            this.chart = new ApexCharts(document.querySelector("#categoryChart"), this.chartOptions);
            this.chart.render();
        },
        updateChartData() {
            if (!this.expensecategories.length) {
                console.log('No expense categories data');
                return;
            }

            // Map categories to series data
            const labels = this.expensecategories.map(cat => cat.name);
            const series = this.expensecategories.map(cat => cat.total_amount || 0);

            console.log('Updating chart with:', {
                labels,
                series,
                categories: this.expensecategories
            });

            // Update chart data
            this.chartOptions.labels = labels;
            this.chartOptions.series = series;

            if (this.chart) {
                this.chart.updateOptions(this.chartOptions);
            } else {
                this.initChart();
            }
        }
    },
    watch: {
        expensecategories: {
            handler(newVal) {
                console.log('expensecategories changed:', newVal);
                this.updateChartData();
            },
            immediate: true,
            deep: true
        }
    },
    mounted() {
        console.log('Component mounted');
        this.updateChartData();
    },
    beforeUnmount() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}
</script>