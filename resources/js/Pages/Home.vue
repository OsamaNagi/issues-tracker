<script setup>
import { Head } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Heading from "@/Components/Heading.vue";
import ProjectBarChart from "@/Components/Charts/ProjectBarChart.vue";
import ProjectVisibilityChart from "@/Components/Charts/ProjectVisibilityChart.vue";
import UserDonutChart from "@/Components/Charts/UserDonutChart.vue";
import UsersTrafficChart from "@/Components/Charts/UsersTrafficChart.vue";
import IssueLabelsChart from "@/Components/Charts/IssueLabelsChart.vue";
import IssuePriorityChart from "@/Components/Charts/IssuePriorityChart.vue";

const props = defineProps({
    publicProjects: {
        type: Number,
        required: true,
    },
    privateProjects: {
        type: Number,
        required: true,
    },
    userRoles: {
        type: Array,
        required: true,
    },
    series: {
        type: Array,
        required: true,
    },
    userIssuesCount: {
        type: Number,
        required: true,
    },
    userIssueLabels: {
        type: Array,
        required: true,
    },
    userIssuesPriority: {
        type: Array,
        required: true,
    },
    breadcrumbs: {
        type: Array,
        required: true,
    },
    heading: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[{ label: 'Home', link: '/' }]"
                heading="Home"
            />

            <div
                class="grid grid-cols-1 gap-x-4 gap-y-8 justify-items-center sm:grid-cols-2"
            >
                <ProjectVisibilityChart
                    :publicProjects="publicProjects"
                    :privateProjects="privateProjects"
                />

                <UsersTrafficChart :userRoles="userRoles" :series="series" />

                <IssueLabelsChart
                    :userIssuesCount="userIssuesCount"
                    :userIssueLabels="userIssueLabels"
                />

                <IssuePriorityChart
                    :userIssuesPriority="userIssuesPriority"
                    :userIssuesCount="userIssuesCount"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
