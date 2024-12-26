<script setup>

import {ref, computed, reactive} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import CreateIssueModal from "@/Components/createIssueModal.vue";
import IssueCard from "@/Components/IssueCard.vue";

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
        <div class="h-screen">
            <div class="flex items-center justify-between">
                <CreateIssueModal :project="project" />
            </div>

            <div
                class="mx-auto mt-6 text-white bg-gray-900 border border-gray-700 rounded-lg"
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
                    <IssueCard :project="project" :issue="issue" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
