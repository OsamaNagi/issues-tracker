<script setup>
import { formatDistanceToNow } from "date-fns";
import { usePage, Link } from "@inertiajs/vue3";
import { computed, reactive } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    canEdit: Boolean,
});

const project = reactive(props.project);

const updatedAt = computed(() => {
    return formatDistanceToNow(new Date(project.updated_at), {
        addSuffix: true,
    });
});
</script>

<template>
    <div
        class="flex items-center justify-between p-4 transition-colors duration-100 bg-white dark:bg-gray-800 hover:bg-gray-700"
    >
        <Link :href="route('project.show', project.id)">
            <!-- Left Content -->
            <div class="flex items-center">
                <span
                    :class="[
                        'w-3 h-3 mr-3 rounded-full',
                        project.status === 'open'
                            ? 'bg-green-500'
                            : 'bg-indigo-500',
                    ]"
                />
                <div
                    class="text-gray-900 dark:text-gray-400 hover:text-blue-400"
                >
                    <h3 class="font-semibold capitalize">
                        @{{ project.creator.name }}'s
                        <span class="text-gray-400">
                            ({{ project.name }})
                        </span>
                    </h3>
                    <p class="text-sm dark:text-gray-400">
                        {{ project.creator.name }} #{{ project.id }} updated
                        {{ updatedAt }}
                    </p>
                </div>
            </div>
        </Link>

        <!-- Right Content -->
        <div class="flex items-center space-x-3">
            <span
                class="px-2 py-1 text-sm text-gray-900 bg-gray-100 rounded dark:text-gray-300 dark:bg-gray-700"
            >
                {{ project.visibility }}
            </span>
            <Link
                v-if="canEdit"
                class="px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                :href="route('project.edit', project.id)"
            >
                Edit
            </Link>
        </div>
    </div>
</template>
