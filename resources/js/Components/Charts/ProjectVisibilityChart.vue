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
    <div
        class="w-full max-w-sm p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6"
    >
        <div
            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700"
        >
            <dl>
                <dt
                    class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1"
                >
                    My projects
                </dt>
                <dd
                    class="mt-1 text-3xl font-bold leading-none text-gray-900 dark:text-white"
                >
                    {{ publicProjects + privateProjects }}
                </dd>
            </dl>
        </div>

        <div class="grid grid-cols-2 py-3">
            <dl>
                <dt
                    class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400"
                >
                    Public
                </dt>
                <dd
                    class="text-xl font-bold leading-none text-green-500 dark:text-green-400"
                >
                    {{ publicProjects }}
                </dd>
            </dl>
            <dl>
                <dt
                    class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400"
                >
                    Private
                </dt>
                <dd
                    class="text-xl font-bold leading-none text-indigo-600 dark:text-indigo-500"
                >
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

<style scoped></style>
