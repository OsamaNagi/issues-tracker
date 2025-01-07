<script setup>
import IssueDonutChart from "@/Components/Charts/IssueDonutChart.vue";
import EmptyState from "@/Components/EmptyState.vue";

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
</script>

<template>
    <div
        class="w-full max-w-sm p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-6"
    >
        <div class="flex justify-between mb-3">
            <div class="flex items-center justify-center">
                <h5
                    class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1"
                >
                    My Issues
                </h5>
            </div>
        </div>

        <!-- Donut Chart -->
        <div class="py-6" id="donut-chart">
            <EmptyState v-if="userIssueLabels.length === 0">
                No issues found.
            </EmptyState>
            <IssueDonutChart
                v-else
                :userIssuesCount="userIssuesCount"
                :userIssueLabels="userIssueLabels"
            />
        </div>
    </div>
</template>

<style scoped></style>
