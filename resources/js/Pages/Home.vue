<script setup>
import {Head} from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Heading from "@/Components/Heading.vue";

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: true,
    },
    heading: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <Head title="Home"/>

    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[{ label: 'Home', link: '/' }]"
                heading="Home"
            />
        </div>
    </AuthenticatedLayout>
</template>
