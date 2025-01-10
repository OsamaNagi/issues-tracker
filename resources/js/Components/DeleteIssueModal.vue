<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    project: Object,
    issue: Object,
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

const form = useForm({});

const submitForm = () => {
    form.delete(
        route("issue.destroy", {
            project: props.project.id,
            issue: props.issue.id,
        }),
        {
            onSuccess: () => {
                closeModal();
            },
            onError: (errors) => {},
        }
    );
};
</script>

<template>
    <!-- Modal toggle -->
    <button
        @click="openModal"
        class="text-red-500 bg-gray-100 border-red-300 hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-red-300 font-bold rounded-md whitespace-nowrap text-xs md:text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-red-700 border dark:border-gray-500"
        type="button"
    >
        Delete issue
    </button>

    <!-- Overlay background (dimmed) -->
    <div
        v-show="isModalOpen"
        class="fixed inset-0 z-40 bg-black bg-opacity-50"
    ></div>

    <!-- Main modal -->
    <div
        v-show="isModalOpen"
        tabindex="-1"
        aria-hidden="true"
        aria-modal="true"
        class="fixed inset-0 z-50 flex items-center justify-center max-h-full overflow-x-hidden overflow-y-auto"
        @keydown.escape="closeModal"
    >
        <div class="relative z-50 w-full max-w-md max-h-full p-4 rounded-lg">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600"
                >
                    <h3
                        class="text-lg font-semibold text-gray-900 dark:text-white"
                    >
                        Are you absolutely sure?
                    </h3>
                    <button
                        @click="closeModal"
                        type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-300">
                        This action cannot be undone. This will permanently
                        delete the issue, saved views, custom fields and
                        associated values, and Insights data.
                    </p>

                    <div class="flex w-full mt-4 space-x-2">
                        <button
                            type="button"
                            @click="closeModal"
                            class="w-1/2 px-4 py-2 text-sm font-bold text-gray-600 bg-gray-200 border rounded-md w-100 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            @click="submitForm"
                            class="w-1/2 px-4 py-2 text-sm font-bold text-white bg-red-500 rounded-md hover:bg-red-600 disabled:opacity-50"
                        >
                            Delete Forever
                        </button>
                    </div>
                </div>
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
