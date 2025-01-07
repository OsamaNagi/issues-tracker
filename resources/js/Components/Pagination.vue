<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    links: Array,
});
</script>

<template>
    <nav
        aria-label="Page navigation example"
        class="flex items-center justify-center"
    >
        <ul class="">
            <li class="inline-flex h-10 -space-x-px text-base">
                <Link
                    v-for="(link, index) in links"
                    :key="index"
                    :href="link.url"
                    v-html="link.label"
                    aria-current="page"
                    :class="[
                        'flex items-center justify-center h-10 px-4 leading-tight border',
                        'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700',
                        'dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white',
                        link.active
                            ? 'bg-blue-100 text-gray-700 dark:bg-gray-900 dark:text-white'
                            : '',
                        link.label.includes('Previous') ? 'rounded-l-md' : '',
                        link.label.includes('Next') ? 'rounded-r-md' : '',
                    ]"
                />
            </li>
        </ul>
    </nav>
</template>
