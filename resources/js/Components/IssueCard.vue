<script setup>

import {computed, reactive} from "vue";
import {formatDistanceToNow} from "date-fns";
import {Link} from "@inertiajs/vue3";

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
const project = reactive(props.project);

const createdAt = computed(() => {
    return formatDistanceToNow(new Date(issue.created_at), {addSuffix: true});
})

const dimColor = (hex) => {
    return hexToRgbA(hex, 0.2);  // Adjust 0.2 for the desired dimming effect
};

// Helper function to convert hex to RGBA
const hexToRgbA = (hex, alpha = 1) => {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
};

</script>

<template>
    <!-- Issues List -->
    <Link :href="route('issue.show', { project: project.id, issue: issue.id })" class="">
        <div
            class="flex items-center justify-between p-4 bg-gray-800 hover:bg-gray-700 transition-colors duration-100"
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
                :style="{
                    backgroundColor: dimColor(label.color),
                    borderColor: label.color,
                    color: label.color
                }"
                class="border px-2 py-1 text-sm font-bold text-white  rounded-full"
            >
                {{ label.name }}
            </span>
            </div>
        </div>
    </Link>
</template>
