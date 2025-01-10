<script setup>
import { onMounted, ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LabelInputField from "@/Components/LabelInputField.vue";
import { formatDistanceToNow } from "date-fns";
import Title from "@/Components/Title.vue";
import DeleteProjectModal from "@/Components/DeleteProjectModal.vue";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const showDeleteModal = ref(false);

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

// Function to handle the modal close
const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

// Initialize the form
const form = useForm({
    name: props.project.name,
    description: props.project.description,
    visibility: props.project.visibility,
});

// Handle form submission
const submitForm = () => {
    form.patch(route("project.update", { project: props.project.id }), {
        onError: (errors) => {
            console.error("Validation errors:", errors);
        },
    });
};

const projectStatusForm = useForm({});

const toggleProjectStatus = () => {
    const action = props.project.status === "open" ? "close" : "reopen";

    projectStatusForm.patch(
        route(`project.${action}`, { project: props.project.id }),
        {
            preserveScroll: true,
            onSuccess: () => {
                // Update project status locally
                props.project.status = action === "close" ? "closed" : "open";
            },
            onError: (errors) => {
                console.error(`Error ${action}ing project:`, errors);
            },
        }
    );
};

const deleteProject = useForm({});

const confirmDeleteProject = () => {
    deleteProject.delete(
        route("project.destroy", { project: props.project.id }),
        {
            onError: (errors) => {
                console.error("Error deleting project:", errors);
            },
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen p-4 md:p-5">
            <div class="flex items-center justify-between">
                <h1
                    class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl dark:text-white"
                >
                    Edit ({{ project.name }}) Project
                </h1>
            </div>

            <form class="mt-6" @submit.prevent="submitForm">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <LabelInputField for="name"
                            >Project Name</LabelInputField
                        >
                        <input
                            id="name"
                            name="name"
                            v-model="form.name"
                            placeholder="Enter Project Name"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        />
                        <p v-if="form.errors.name" class="text-sm text-red-500">
                            {{ form.errors.name }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <LabelInputField for="description"
                            >Description</LabelInputField
                        >
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Enter Project Description"
                            required
                            v-model="form.description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <p
                            v-if="form.errors.description"
                            class="text-sm text-red-500"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>
                    <div class="flex gap-x-4">
                        <div class="flex items-center">
                            <input
                                checked
                                id="default-radio-1"
                                v-model="form.visibility"
                                type="radio"
                                value="private"
                                name="visibility"
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label
                                for="default-radio-1"
                                class="font-medium text-gray-900 ms-2 text-md dark:text-gray-300"
                                >Private</label
                            >
                        </div>
                        <div class="flex items-center">
                            <input
                                id="default-radio-2"
                                v-model="form.visibility"
                                type="radio"
                                value="public"
                                name="visibility"
                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                            <label
                                for="default-radio-2"
                                class="font-medium text-gray-900 ms-2 text-md dark:text-gray-300"
                                >Public</label
                            >
                        </div>
                    </div>
                </div>
                <div class="flex gap-x-4">
                    <PrimaryButton type="submit" class="flex">
                        <svg
                            class="w-5 h-5 me-1 -ms-1"
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
                        Update Project
                    </PrimaryButton>
                    <Link
                        :href="route('projects.index', project.id)"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                    >
                        Cancel
                    </Link>
                </div>
                <div class="mt-6">
                    <p class="text-sm text-gray-500">
                        This project was last updated on
                        {{
                            formatDistanceToNow(new Date(project.updated_at), {
                                addSuffix: true,
                            })
                        }}
                    </p>
                </div>
            </form>

            <Title class="mt-10"> Danger Zone </Title>
            <div
                class="relative mt-6 overflow-x-auto border border-red-600 rounded-lg shadow-md"
            >
                <table
                    class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400"
                >
                    <tbody class="">
                        <tr class="border-b dark:border-gray-700">
                            <th
                                scope="row"
                                class="px-4 py-4 font-bold text-gray-900 text-md dark:text-white"
                            >
                                <p>
                                    {{
                                        project.status === "open"
                                            ? "Close project"
                                            : "Re-open project"
                                    }}
                                </p>
                                <p class="mt-2">
                                    {{
                                        project.status === "open"
                                            ? "Closing a project will disable its workflows & remove it from the list of open projects."
                                            : "Re-opening a project will add it to the list of open projects."
                                    }}
                                </p>
                            </th>

                            <td class="py-8 pr-4 text-right">
                                <button
                                    type="button"
                                    @click="toggleProjectStatus"
                                    :disabled="projectStatusForm.processing"
                                    class="text-red-500 bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-bold rounded-lg whitespace-nowrap text-xs md:text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                >
                                    <span v-if="projectStatusForm.processing"
                                        >Processing...</span
                                    >
                                    <span v-else>
                                        {{
                                            project.status === "open"
                                                ? "Close this project"
                                                : "Reopen this project"
                                        }}
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b dark:border-gray-700">
                            <th
                                scope="row"
                                class="px-4 py-4 font-bold text-gray-900 text-md dark:text-white"
                            >
                                <p>Delete project</p>
                                <p class="mt-2">
                                    Once you delete a project, there is no going
                                    back. Please be certain.
                                </p>
                            </th>

                            <td class="py-8 pr-4 text-right">
                                <button
                                    type="button"
                                    @click="openDeleteModal"
                                    class="text-red-500 bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-bold rounded-lg whitespace-nowrap text-xs md:text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                                >
                                    Delete this project
                                </button>

                                <DeleteProjectModal
                                    :show="showDeleteModal"
                                    @close="closeDeleteModal"
                                    :project-name="project.name"
                                    :confirmation-message="`@${props.project.creator.name}'s ${props.project.name}`"
                                    @confirm="confirmDeleteProject"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
