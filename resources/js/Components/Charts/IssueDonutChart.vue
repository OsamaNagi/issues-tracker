<script setup>
import { ref, watch } from "vue";
import ApexCharts from "vue3-apexcharts";

const props = defineProps({
    userIssuesCount: {
        type: Number,
        required: true,
    },
    userIssueLabels: {
        type: Array,
        required: true,
    },
});

// Reactive chart options
const chartOptions = ref({
    chart: {
        height: 320,
        width: "100%",
        type: "donut",
    },
    colors: [],
    stroke: {
        colors: ["transparent"],
    },
    plotOptions: {
        pie: {
            donut: {
                labels: {
                    show: true,
                    name: {
                        show: true,
                        fontFamily: "Inter, sans-serif",
                        offsetY: 20,
                    },
                    total: {
                        showAlways: true,
                        show: true,
                        label: "Total Issues",
                        fontFamily: "Inter, sans-serif",
                        formatter: function () {
                            return props.userIssuesCount;
                        },
                    },
                    value: {
                        show: true,
                        fontFamily: "Inter, sans-serif",
                        offsetY: -20,
                        formatter: function (value) {
                            return value;
                        },
                    },
                },
                size: "80%",
            },
        },
    },
    grid: {
        padding: {
            top: -2,
        },
    },
    labels: [],
    dataLabels: {
        enabled: false,
    },
    legend: {
        position: "bottom",
        fontFamily: "Inter, sans-serif",
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return value;
            },
        },
    },
    xaxis: {
        labels: {
            formatter: function (value) {
                return value;
            },
        },
        axisTicks: {
            show: false,
        },
        axisBorder: {
            show: false,
        },
    },
});

// Reactive series and colors
const chartSeries = ref([]);
const chartColors = ref([]);
const chartLabels = ref([]);

// Watch for changes in props and update chart data
watch(
    () => props.userIssueLabels,
    (newLabels) => {
        console.log("newLabels:", newLabels); // Debugging line
        chartLabels.value = newLabels.map((label) => label.name); // Extract names
        chartColors.value = newLabels.map((label) => label.color); // Extract colors
        chartSeries.value = newLabels.map((label) => label.count); // Use count for series
        chartOptions.value.labels = chartLabels.value;
        chartOptions.value.colors = chartColors.value;
    },
    { immediate: true }
);
</script>

<template>
    <div class="p-4 bg-white dark:bg-gray-800">
        <!-- Chart -->
        <ApexCharts
            type="donut"
            :options="chartOptions"
            :series="chartSeries"
        />
    </div>
</template>

<style scoped>
/* Add custom Flowbite-based styling if necessary */
</style>
