<script setup>
import { formatDistanceToNow } from "date-fns";

const props = defineProps({
    log: Object,
});
</script>

<template>
    <div
        class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600"
    >
        <div class="items-center justify-between mb-3 sm:flex">
            <time
                class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0"
            >
                {{ formatDistanceToNow(new Date(log.created_at)) }}
            </time>
            <div
                class="text-sm font-normal text-gray-500 lex dark:text-gray-300"
            >
                {{ log.causer.name }} commented on
                <a
                    href="#"
                    class="font-semibold text-gray-900 dark:text-white hover:underline"
                >
                    {{ log.subject.title }}
                </a>
            </div>
        </div>
        <div
            class="p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300"
        >
            {{ log.properties.content }}
        </div>
    </div>
</template>
