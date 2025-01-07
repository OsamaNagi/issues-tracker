<script setup>
import { ref } from "vue";
import ApexCharts from "vue3-apexcharts";

const props = defineProps({
    userIssuesPriority: {
        type: Array,
        required: true,
    },
});

const series = ref([
    {
        name: props.userIssuesPriority.map((priority) => priority.name),
        data: props.userIssuesPriority.map((priority) => priority.count),
    },
]);

const options = ref({
    xaxis: {
        categories: props.userIssuesPriority.map((priority) => priority.name),
    },
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800">
        <ApexCharts type="bar" :series="series" :options="options" />
    </div>
</template>

<style scoped>
/* Add custom Flowbite-based styling if necessary */
</style>
