<script setup>
import IssueBarChart from "@/Components/Charts/IssueBarChart.vue";

const props = defineProps({
    userIssuesCount: {
        type: Number,
        required: true,
    },
    userIssuesPriority: {
        type: Array,
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
                    My issues priority
                </dt>
                <dd
                    class="mt-1 text-3xl font-bold leading-none text-gray-900 dark:text-white"
                >
                    {{ userIssuesCount }}
                </dd>
            </dl>
        </div>

        <div class="grid grid-cols-4 py-3">
            <dl v-for="priority in userIssuesPriority" :key="priority.id">
                <dt
                    class="pb-1 text-base font-normal text-gray-500 dark:text-gray-400"
                >
                    {{ priority.name }}
                </dt>
                <dd
                    class="text-xl font-bold leading-none text-gray-500 dark:text-gray-400"
                >
                    {{ priority.count }}
                </dd>
            </dl>
        </div>

        <IssueBarChart :userIssuesPriority="userIssuesPriority" />
    </div>
</template>

<style scoped></style>
