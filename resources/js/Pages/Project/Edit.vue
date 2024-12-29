<script setup>

import LabelInputField from "@/Components/LabelInputField.vue";
import {useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

// Initialize the form
const form = useForm({
    title: '',
    description: '',
});

// Handle form submission
const submitForm = () => {
    form.post(route('issue.store', {project: props.project.id}), {
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-screen">
            <div class="flex items-center justify-between">
                <p class="text-lg font-bold text-slate-50">Edit project</p>
            </div>

            <form class="p-4 md:p-5" @submit.prevent="submitForm">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <!-- Title Field -->
                    <div class="col-span-2">
                        <LabelInputField for="title">Project title</LabelInputField>
                        <input
                            id="title"
                            name="title"
                            v-model="form.title"
                            type="text"
                            class="w-full rounded-lg p-2 bg-gray-800 text-gray-50"
                        />
                    </div>

                    <!-- Description Field -->
                    <div class="col-span-2">
                        <LabelInputField for="description">Project description</LabelInputField>
                        <textarea
                            id="description"
                            name="description"
                            v-model="form.description"
                            class="w-full rounded-lg p-2 bg-gray-800 text-gray-50"
                        ></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-span-2">
                        <PrimaryButton type="submit">Update project</PrimaryButton>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
