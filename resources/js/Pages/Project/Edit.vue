<script setup>
import {ref} from "vue";
import {useForm, Link} from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LabelInputField from "@/Components/LabelInputField.vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

// Initialize the form
const form = useForm({
    name: props.project.name,
    description: props.project.description,
    visibility: props.project.visibility,
});

// Handle form submission
const submitForm = () => {
    form.patch(route('project.update', { project: props.project.id }), {
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="h-screen p-4 md:p-5">
            <div class="flex items-center justify-between">
                <p class="text-lg font-bold text-slate-50">
                    Edit ({{ project.name }}) Project
                </p>
            </div>

            <form class="mt-6" @submit.prevent="submitForm">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <LabelInputField for="name">Project Name</LabelInputField>
                        <input id="name"
                               name="name"
                               v-model="form.name"
                               placeholder="Enter Project Name"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                        <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
                    </div>
                    <div class="col-span-2">
                        <LabelInputField for="description">Description</LabelInputField>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Enter Project Description"
                                  required
                                  v-model="form.description"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <p v-if="form.errors.description" class="text-red-500 text-sm">{{
                                form.errors.description
                            }}</p>
                    </div>
                    <div class="flex gap-x-4">
                        <div class="flex items-center">
                            <input checked id="default-radio-1" v-model="form.visibility"
                                   type="radio" value="private" name="visibility"
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1"
                                   class="ms-2 text-md font-medium text-gray-900 dark:text-gray-300">Private</label>
                        </div>
                        <div class="flex items-center">
                            <input id="default-radio-2" v-model="form.visibility"
                                   type="radio" value="public" name="visibility"
                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-2"
                                   class="ms-2 text-md font-medium text-gray-900 dark:text-gray-300">Public</label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-4">
                    <PrimaryButton type="submit" class="flex">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Update Project
                    </PrimaryButton>
                    <Link :href="route('home', project.id)"
                          class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
