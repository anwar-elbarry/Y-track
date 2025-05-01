<template>
    <div class="w-full h-[400px] bg-white rounded-xl shadow-lg p-4">
        <div v-if="!expensecategories.length" class="flex items-center justify-center h-full text-gray-500">
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
    methods: {
        getChartOptions(series, labels) {
            console.log('Chart data:', { series, labels }); // Debug log
            return {
                series,
                labels,
                chart: {
                    type: 'donut',
                    height: 350,
                    toolbar: { show: true },
                    background: 'transparent'
                },
                colors: [
                    '#ef4444', '#3b82f6', '#22c55e', '#f59e0b', '#8b5cf6', '#ec4899'
                ],
                legend: {
                    position: 'bottom',
                    formatter: (seriesName, opts) => {
                        return `${seriesName}: ${opts.w.globals.series[opts.seriesIndex]}`
                    }
                },
                plotOptions: {
                    pie: {
                        donut: { 
                            size: '70%',
                            labels: {
                                show: true
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val, opts) => {
                        const amount = opts.w.globals.series[opts.seriesIndex];
                        return `${opts.w.config.labels[opts.seriesIndex]}\n${amount} ${this.currency}`;
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => `${val} ${this.currency}`
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
            };
        },
        initChart() {
            if (this.chart) {
                this.chart.destroy();
                this.chart = null;
            }

            const chartElement = document.querySelector("#categoryChart");
            if (!chartElement) {
                console.error("Chart element not found");
                return;
            }

            // Filter out categories with zero amounts
            const validCategories = this.expensecategories.filter(cat => cat.total_amount > 0);
            const labels = validCategories.map(cat => cat.name);
            const series = validCategories.map(cat => cat.total_amount);

            if (series.length === 0) {
                console.warn("No valid data to display in chart");
                return;
            }

            console.log('Initializing chart with:', { labels, series }); // Debug log
            const options = this.getChartOptions(series, labels);
            this.chart = new ApexCharts(chartElement, options);
            this.chart.render();
        },
        updateChartData() {
            if (!this.chart) return;

            // Filter out categories with zero amounts
            const validCategories = this.expensecategories.filter(cat => cat.total_amount > 0);
            const labels = validCategories.map(cat => cat.name);
            const series = validCategories.map(cat => cat.total_amount);

            if (series.length === 0) {
                if (this.chart) {
                    this.chart.destroy();
                    this.chart = null;
                }
                return;
            }

            console.log('Updating chart with:', { labels, series }); // Debug log
            const newOptions = this.getChartOptions(series, labels);
            this.chart.updateOptions(newOptions, true);
        }
    },
    watch: {
        expensecategories: {
            handler() {
                this.$nextTick(() => {
                    if (!this.chart) {
                        this.initChart();
                    } else {
                        this.updateChartData();
                    }
                });
            },
            immediate: true,
            deep: true
        }
    },
    mounted() {
        this.$nextTick(() => {
            if (this.expensecategories.length) {
                this.initChart();
            }
        });
    },
    beforeUnmount() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}
</script>
