<script setup>

import {ref, computed, reactive} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import CreateIssueModal from "@/Components/createIssueModal.vue";
import IssueCard from "@/Components/IssueCard.vue";
import {Link} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";

const props = defineProps({
    project: {
        type: Object,
    },
    issues: {
        type: Object,
    },
});

const issues = reactive(props.issues);

const tab = ref('open'); // Track the selected tab

// Computed property to filter projects based on the selected tab
const filteredIssues = computed(() => {
    return issues.filter(issue => issue.status === tab.value);
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[
                    { label: 'Projects', link: '/projects' },
                    { label: props.project.name }
                 ]"
                heading="Issues"
            />

            <div class="flex items-center justify-between">
                <Link
                    class="px-5 py-2 text-sm font-bold text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    :href="route('issue.create', { project: props.project.id })">Create Issue
                </Link>
                <Link
                    class="px-5 py-2 text-sm font-bold text-white bg-gray-700 rounded-md hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800"
                    :href="route('project.ShowProjectUsers', { project: props.project.id })">Add user to project
                </Link>
            </div>

            <div
                class="mx-auto mt-6 text-white dark:bg-gray-900 border rounded-lg dark:border-gray-800 border-gray-50"
            >
                <!-- Tabs -->
                <div class="flex items-center justify-between p-2">
                    <div class="flex space-x-4">
                        <button
                            class="px-4 py-2 text-sm font-medium transition-all rounded-md"
                            :class="
                                tab === 'open'
                                    ? 'bg-gray-700 text-white'
                                    : 'text-gray-400'
                            "
                            @click="tab = 'open'"
                        >
                            Open
                        </button>
                        <button
                            class="px-4 py-2 text-sm font-medium transition-all rounded-md"
                            :class="
                                tab === 'closed'
                                    ? 'bg-gray-700 text-white'
                                    : 'text-gray-400'
                            "
                            @click="tab = 'closed'"
                        >
                            Closed
                        </button>
                    </div>
                </div>
                <!-- Issues List -->
                <div v-for="issue in filteredIssues" :key="issue.id">
                    <IssueCard :project="project" :issue="issue"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
