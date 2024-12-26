<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

// Sample Data
const issues = ref([
    {
        id: 3,
        repo: "OsamaNagi/laravel-filament",
        title: "adsdasd",
        author: "OsamaNagi",
        daysAgo: 2,
        labels: ["bug"],
        status: "open",
    },
]);

const tab = ref("open");

// Filter issues based on tab
const filteredIssues = computed(() => {
    return issues.value.filter((issue) => issue.status === tab.value);
});
</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <div class="h-screen">
            <div class="flex items-center justify-between">
                <p class="text-lg font-bold text-slate-50">Created by me</p>
                <PrimaryButton>Create Project</PrimaryButton>
            </div>

            <div
                class="mx-auto mt-6 text-white bg-gray-900 border border-gray-700 rounded-lg"
            >
                <!-- Tabs -->
                <div class="flex items-center justify-between p-2">
                    <div class="flex space-x-4">
                        <button
                            class="px-4 py-2 text-sm font-medium transition-all rounded-md"
                            :class="
                                tab === 'open'
                                    ? 'bg-gray-700 text-white'
                                    : 'text-gray-400'
                            "
                            @click="tab = 'open'"
                        >
                            Open
                        </button>
                        <button
                            class="px-4 py-2 text-sm font-medium transition-all rounded-md"
                            :class="
                                tab === 'closed'
                                    ? 'bg-gray-700 text-white'
                                    : 'text-gray-400'
                            "
                            @click="tab = 'closed'"
                        >
                            Closed
                        </button>
                    </div>
                </div>
                <!-- Project List -->
                <div
                    class="flex items-center justify-between p-4 bg-gray-800 rounded-b-lg"
                >
                    <!-- Left Content -->
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="w-6 h-6 mr-3 text-gray-400"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 10h11M9 21V3m-6 7h6M21 21h-6m0-6h6"
                            />
                        </svg>
                        <div>
                            <h3 class="font-semibold">
                                @OsamaNagi's
                                <span class="text-gray-400"
                                    >untitled project</span
                                >
                            </h3>
                            <p class="text-sm text-gray-400">
                                OsamaNagi #2 updated 19 hours ago
                            </p>
                        </div>
                    </div>

                    <!-- Right Content -->
                    <div class="flex items-center space-x-3">
                        <span
                            class="px-2 py-1 text-sm text-gray-300 bg-gray-700 rounded"
                            >Private</span
                        >
                        <button class="text-gray-400 hover:text-white">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 10h12M6 14h12m-7 4h7M5 18H4m1-8H4m1-4H4"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
