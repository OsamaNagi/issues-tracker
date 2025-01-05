<script setup>
import {formatDistanceToNow} from 'date-fns';
import {usePage, Link} from "@inertiajs/vue3";
import {computed, reactive} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
})

const project = reactive(props.project);

const updatedAt = computed(() => {
    return formatDistanceToNow(new Date(project.updated_at), {addSuffix: true});
})
</script>

<template>
    <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 hover:bg-gray-700 transition-colors duration-100">
        <Link :href="route('project.show', project.id)">
            <!-- Left Content -->
            <div class="flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    class="w-6 h-6 mr-3 text-gray-400"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 10h11M9 21V3m-6 7h6M21 21h-6m0-6h6"
                    />
                </svg>
                <div class="text-gray-900 dark:text-gray-400 hover:text-blue-400">
                    <h3 class="font-semibold capitalize">
                        @{{ project.creator.name }}'s
                        <span class="text-gray-400">
                        ({{ project.name }})
                    </span>
                    </h3>
                    <p class="text-sm  dark:text-gray-400">
                        {{ project.creator.name }} #{{ project.id }} updated {{ updatedAt }}
                    </p>
                </div>
            </div>
        </Link>

        <!-- Right Content -->
        <div class="flex items-center space-x-3">
            <span class="px-2 py-1 text-sm text-gray-900 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded"
            >
                {{ project.visibility }}
            </span>
            <Link
                class="px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                :href="route('project.edit', project.id)"
            >
                Edit
            </Link>
        </div>
    </div>

</template>
