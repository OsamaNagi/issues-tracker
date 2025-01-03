<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LabelInputField from "@/Components/LabelInputField.vue";
import { useForm } from "@inertiajs/vue3";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    issue: {
        type: Object,
    },
    labels: {
        type: Object,
    },
    projectUsers: {
        type: Object,
    }
});

// Initialize the form
const form = useForm({
    title: props.issue.title,
    description: props.issue.description,
    priority: props.issue.priority,
    label_ids: props.issue.labels.map(label => label.id),
    assignee_ids: props.issue.assignees.map(user => user.id),
});

// Handle form submission
const submitForm = () => {
    form.patch(route('issue.update', { project: props.project.id, issue: props.issue.id }), {
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>


<template>
    <AuthenticatedLayout>
        <div class="min-h-screen">
            <div class="flex items-center justify-between">
                <p class="text-lg font-bold text-slate-50">
                    Edit Issue: {{ issue.title }}
                </p>
            </div>

            <form class="p-4 md:p-5" @submit.prevent="submitForm">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <!-- Title Field -->
                    <div class="col-span-2">
                        <LabelInputField for="title">Issue title</LabelInputField>
                        <input
                            id="title"
                            name="title"
                            v-model="form.title"
                            placeholder="Enter issue title"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        />
                        <p v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</p>
                    </div>

                    <!-- Description Field -->
                    <div class="col-span-2">
                        <LabelInputField for="description">Description</LabelInputField>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Enter issue description"
                            required
                            v-model="form.description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        ></textarea>
                        <p v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</p>
                    </div>

                    <!-- Priority Field -->
                    <div class="col-span-2">
                        <label
                            for="priority"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Priority
                        </label>
                        <select
                            id="priority"
                            v-model="form.priority"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                        <p v-if="form.errors.priority" class="text-red-500 text-sm">{{ form.errors.priority }}</p>
                    </div>

                    <!-- Labels Field -->
                    <div class="col-span-2">
                        <label
                            for="label"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Label
                        </label>
                        <v-select
                            id="label"
                            v-model="form.label_ids"
                            multiple
                            :options="labels"
                            label="name"
                            :reduce="label => label.id"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <p v-if="form.errors.label_id" class="text-red-500 text-sm">{{ form.errors.label_id }}</p>
                    </div>

                    <!-- assignee user Field -->
                    <div class="col-span-2">
                        <label
                            for="assignees"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Assignee User
                        </label>
                        <v-select
                            id="assignees"
                            v-model="form.assignee_ids"
                            multiple
                            :options="projectUsers"
                            label="name"
                            :reduce="user => user.id"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        <p v-if="form.errors.assignee_ids" class="text-red-500 text-sm">{{ form.errors.assignee_ids }}</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <PrimaryButton type="submit" class="flex">
                    <svg
                        class="me-1 -ms-1 w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    Update Issue
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>



<style scoped>

</style>
