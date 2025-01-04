<script setup>
import {ref} from "vue";
import InputField from "@/Components/InputField.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextareaField from "@/Components/TextareaField.vue";
import LabelInputField from "@/Components/LabelInputField.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    project: Object,
    users: Object,
});

// Initialize the form
const form = useForm({
    user_ids: [],
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
    form.post(route('project.add-users', { project: props.project.id} ), {
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
        Add User
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
        <div class="relative p-4 w-full max-w-md max-h-full  rounded-lg  z-50">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg  dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add user to the project
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
                    <div class="col-span-2">
                        <label
                            for="label"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >
                            Users
                        </label>
                        <v-select
                            id="label"
                            v-model="form.user_ids"
                            multiple
                            :options="users"
                            label="name"
                            :reduce="user => user.id"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                        <p v-if="form.errors.user_id" class="text-red-500 text-sm">{{ form.errors.user_id }}</p>
                    </div>
                    <PrimaryButton type="submit" class="flex mt-10">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                        Add User
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
