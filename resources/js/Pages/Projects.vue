<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed, reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProjectCard from "@/Components/ProjectCard.vue";
import Heading from "@/Components/Heading.vue";
import Pagination from "@/Components/Pagination.vue";
import EmptyState from "@/Components/EmptyState.vue";

const props = defineProps({
    projects: Object,
    canEditProject: Boolean,
});

const projects = reactive(props.projects);

const tab = ref("open"); // Track the selected tab

// Computed property to filter projects based on the selected tab
const filteredProjects = computed(() => {
    return projects.data.filter((project) => project.status === tab.value);
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[{ label: 'Projects', link: '/projects' }]"
                heading="Projects"
            />

            <div class="flex justify-end">
                <Link
                    class="px-5 py-2 text-sm font-bold text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    :href="route('project.create')"
                    >Create Project</Link
                >
            </div>

            <div
                class="mx-auto mt-6 text-white border rounded-lg dark:bg-gray-900 dark:border-gray-800 border-gray-50"
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
                <!-- Project List -->
                <div v-for="project in filteredProjects" :key="project.id">
                    <ProjectCard
                        :canEdit="project.canEdit"
                        :project="project"
                    />
                </div>
            </div>

            <EmptyState class="mt-10" v-if="filteredProjects.length === 0">
                No projects found
            </EmptyState>

            <!-- Pagination -->
            <div class="mt-6" v-if="projects.links.length >= 10">
                <Pagination :links="projects.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
