<script setup>

import {computed, reactive} from "vue";
import {formatDistanceToNow} from "date-fns";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    issue: {
        type: Object,
        required: true,
    },
});

const issue = reactive(props.issue);

const createdAt = computed(() => {
    return formatDistanceToNow(new Date(issue.created_at), { addSuffix: true });
})

</script>

<template>
    <!-- Issues List -->
    <div
        class="flex items-center justify-between p-4 bg-gray-800 rounded-b-lg"
    >
        <!-- Left Content -->
        <div class="flex items-center">
            <span class="w-3 h-3 mr-3 bg-green-500 rounded-full"></span>
            <div>
                <h3 class="font-semibold">
                    {{ project.name }}/
                    <span class="text-gray-400">{{ issue.title }}</span>
                </h3>
                <p class="text-sm text-gray-400">
                    #{{ issue.id }} opened {{ createdAt }} by {{ issue.created_by }}
                </p>
            </div>
        </div>

        <!-- Labels -->
        <div>
            <span
                v-for="label in issue.labels"
                :key="label"
                class="px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full"
            >
                {{ label }}
            </span>
        </div>
    </div>
</template>
