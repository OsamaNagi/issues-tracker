<script setup>
import { ref } from "vue";
import ApexCharts from "vue3-apexcharts";

const chartOptions = {
    chart: {
        height: "100%",
        type: "area",
        toolbar: {
            show: false,
        },
        fontFamily: "Inter, sans-serif",
    },
    fill: {
        type: "gradient",
        gradient: {
            opacityFrom: 0.55,
            opacityTo: 0,
            shade: "#1C64F2",
            gradientToColors: ["#1C64F2"],
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        width: 6,
    },
    grid: {
        show: false,
    },
    series: [
        {
            name: "New users",
            data: [6500, 6418, 6456, 6526, 6356, 6456],
            color: "#1A56DB",
        },
    ],
    xaxis: {
        categories: [
            "01 February",
            "02 February",
            "03 February",
            "04 February",
            "05 February",
            "06 February",
            "07 February",
        ],
        labels: {
            show: true,
        },
    },
    yaxis: {
        labels: {
            show: true,
        },
    },
};
</script>

<template>
    <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            Area Chart
        </div>
        <ApexCharts type="area" width="100%" :options="chartOptions" />
    </div>
</template>

<style scoped>
/* Add custom Flowbite-based styling if necessary */
</style>
