<script setup>

import ProjectBarChart from "@/Components/Charts/ProjectBarChart.vue";

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

</script>

<template>
    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
            <dl>
                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Projects</dt>
                <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">
                    {{ publicProjects + privateProjects }}
                </dd>
            </dl>
        </div>

        <div class="grid grid-cols-2 py-3">
            <dl>
                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Public</dt>
                <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">
                    {{ publicProjects }}
                </dd>
            </dl>
            <dl>
                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Private</dt>
                <dd class="leading-none text-xl font-bold text-indigo-600 dark:text-indigo-500">
                    {{ privateProjects }}
                </dd>
            </dl>
        </div>

        <ProjectBarChart
            :publicProjects="publicProjects"
            :privateProjects="privateProjects"
        />
    </div>
</template>

<style scoped>

</style>
