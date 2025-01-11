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
                <span
                    class="font-semibold text-gray-900 truncate dark:text-white w-96"
                    >{{ log.description }}</span
                >
            </div>
        </div>
    </div>
</template>
