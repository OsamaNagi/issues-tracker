<script setup>
import { ref, watch } from "vue";
import ApexCharts from "vue3-apexcharts";

const props = defineProps({
    userRoles: {
        type: Array,
        required: true,
    },
    series: {
        type: Array,
        required: true,
    },
});

// Options configuration
const chartOptions = ref({
    chart: {
        height: 320,
        width: "100%",
        type: "donut",
    },
    colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
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
                        label: "Unique visitors",
                        fontFamily: "Inter, sans-serif",
                        formatter: function (w) {
                            const sum = w.globals.seriesTotals.reduce(
                                (a, b) => a + b,
                                0
                            );
                            return sum;
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
    labels: ["Admin", "Manager", "Developer", "Client"],
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

// Reactive series and labels
const chartSeries = ref([]);
const userRoles = ref([]);

// Watch for changes in props and update chart data
watch(
    () => props.series,
    (newSeries) => {
        chartSeries.value = newSeries;
    },
    { immediate: true }
);

watch(
    () => props.labels,
    (newUserRoles) => {
        userRoles.value = newUserRoles;
        chartOptions.value.userRoles = newUserRoles; // Update chart options
    },
    { immediate: true }
);
</script>

<template>
    <div class="bg-white dark:bg-gray-800">
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
