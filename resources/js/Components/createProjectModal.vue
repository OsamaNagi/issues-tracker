<script setup>
import {ref} from "vue";
import InputField from "@/Components/InputField.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextareaField from "@/Components/TextareaField.vue";
import LabelInputField from "@/Components/LabelInputField.vue";
import {useForm} from "@inertiajs/vue3";

// Initialize the form
const form = useForm({
    name: '',
    description: '',
    visibility: 'private',
});

// Define a ref to control the modal visibility
const isModalOpen = ref(false);

// Method to open the modal
const openModal = () => {
    isModalOpen.value = true;
};

// Method to close the modal
const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

// Handle form submission
const submitForm = () => {
    form.post(route('project.store'), {
        onSuccess: () => {
            alert('Project created successfully!');
            closeModal();
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <!-- Modal toggle -->
    <button
        @click="openModal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button"
    >
        Create Project
    </button>

    <!-- Overlay background (dimmed) -->
    <div v-show="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Main modal -->
    <div
        v-show="isModalOpen"
        tabindex="-1"
        aria-hidden="true"
        aria-modal="true"
        class="fixed inset-0 z-50 flex items-center justify-center max-h-full overflow-x-hidden overflow-y-auto"
        @keydown.escape="closeModal"
    >
        <div class="relative p-4 w-full max-w-md max-h-full  rounded-lg shadow-lg z-50">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Project
                    </h3>
                    <button
                        @click="closeModal"
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" @submit.prevent="submitForm">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <LabelInputField for="name">Project Name</LabelInputField>
                            <input id="name" name="name" v-model="form.name"
                                   placeholder="Enter Project Name" required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                            <p v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</p>
                        </div>
                        <div class="col-span-2">
                            <LabelInputField for="description">Description</LabelInputField>
                            <textarea id="description" name="description" rows="4"
                                      placeholder="Enter Project Description" required v-model="form.description"
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
                    <PrimaryButton type="submit" class="flex">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Create Project
                    </PrimaryButton>
                </form>

            </div>
        </div>
    </div>
</template>

<style scoped>
/* Ensure modal is centered */
.fixed.inset-0 {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Dim background */
.bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
