<script setup>
const props = defineProps({
    meta: Object,
});
</script>

<template>
    <Component
        v-for="link in meta.links"
        :is="link.url ? 'Link' : 'span'"
        :href="link.url"
        v-html="link.label"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md dark:text-gray-300 dark:bg-gray-800"
        :class="{ 'bg-gray-100 dark:bg-gray-700': link.active }"
    />
</template>
