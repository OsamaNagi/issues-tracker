<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div
            class="p-6 text-left font-bold bg-white rounded-md shadow-lg dark:bg-gray-800 w-[24rem]"
        >
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                Are you absolutely sure?
            </h3>
            <p class="mt-2 text-gray-600 text-md dark:text-gray-400">
                This action cannot be undone. This will permanently delete the
                <span class="text-red-400">({{ projectName }})</span> project,
                saved views, custom fields and associated values, and Insights
                data.
            </p>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Please type
                <span class="text-gray-900 dark:text-gray-50">{{
                    confirmationMessage
                }}</span>
                to confirm.
            </p>
            <input
                type="text"
                v-model="confirmationText"
                placeholder="Type here..."
                class="block w-full p-2 mt-4 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />
            <div class="flex w-full mt-4 space-x-2">
                <button
                    @click="$emit('close')"
                    class="w-1/2 px-4 py-2 text-sm font-bold text-gray-600 bg-gray-200 rounded-md w-100 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                >
                    Cancel
                </button>
                <button
                    @click="confirmDeletion"
                    :disabled="confirmationText !== confirmationMessage"
                    class="w-1/2 px-4 py-2 text-sm font-bold text-white bg-red-500 rounded-md hover:bg-red-600 disabled:opacity-50"
                >
                    Delete Forever
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    confirmationMessage: {
        type: String,
        required: true,
    },
    projectName: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(["close", "confirm"]);
const confirmationText = ref("");

const confirmDeletion = () => {
    emit("confirm");
    confirmationText.value = ""; // Reset input after confirmation
};
</script>
