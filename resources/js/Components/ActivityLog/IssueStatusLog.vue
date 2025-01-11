<script setup>
import { formatDistanceToNow } from "date-fns";

const props = defineProps({
    log: Object,
});
</script>

<template>
    <div
        class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600"
    >
        <time
            class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0"
        >
            {{ formatDistanceToNow(new Date(log.created_at)) }}
        </time>
        <div
            class="flex items-center justify-center space-x-2 text-sm font-normal text-gray-500 dark:text-gray-300"
        >
            <div class="flex items-center space-x-1">
                <span class="">{{ log.causer.name }}</span>
                <span class="font-semibold text-gray-900 dark:text-white">{{
                    log.description
                }}</span>
            </div>

            <svg
                v-if="log.log_name === 'close_issue'"
                class="w-6 h-6 text-indigo-600"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            <svg
                v-else
                class="w-6 h-6 text-green-500"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"
                />
            </svg>
        </div>
    </div>
</template>
