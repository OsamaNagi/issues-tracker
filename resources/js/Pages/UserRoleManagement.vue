<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Heading from "@/Components/Heading.vue";

</script>

<template>
    <Head title="User Role Management" />

    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[{ label: 'Manage Role Assignment', link: '/user-role-management' }]"
                heading="Manage Role Assignment"
            />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
