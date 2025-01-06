<script setup>
import { ref } from "vue";
import ApexCharts from "vue3-apexcharts";

const props = defineProps({
    publicProjects: {
        type: Number,
        required: true,
    },
    privateProjects: {
        type: Number,
        required: true,
    },
});

const series = ref([{
    name: 'visibility',
    data: [props.publicProjects, props.privateProjects]
}]);

const options = ref({
    xaxis: {
        categories: ['public', 'private']
    },
})

</script>

<template>
    <div class="bg-white dark:bg-gray-800">
        <ApexCharts
            type="bar"
            :series="series"
            :options="options"
        />
    </div>
</template>

<style scoped>
/* Add custom Flowbite-based styling if necessary */
</style>
