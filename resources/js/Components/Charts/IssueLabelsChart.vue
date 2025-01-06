<script setup>

import UserDonutChart from "@/Components/Charts/UserDonutChart.vue";

const props = defineProps({
    labels: {
        type: Array,
        required: true,
    },
    series: {
        type: Array,
        required: true,
    },
});
</script>

<template>

    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">

        <div class="flex justify-between mb-3">
            <div class="flex justify-center items-center">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Website traffic</h5>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="py-6" id="donut-chart">
            <UserDonutChart
                :labels="labels"
                :series="series"
            />
        </div>

    </div>

</template>

<style scoped>

</style>
