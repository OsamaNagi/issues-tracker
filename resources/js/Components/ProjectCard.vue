<script setup>
import { formatDistanceToNow } from 'date-fns';
import {usePage} from "@inertiajs/vue3";
import {computed, reactive} from "vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
})

const project = reactive(props.project);

const updatedAt = computed(() => {
    return formatDistanceToNow(new Date(project.updated_at), { addSuffix: true });
})
</script>

<template>
    <div class="flex items-center justify-between p-4 bg-gray-800 ">
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
                <h3 class="font-semibold capitalize">
                    @{{ user.name }}'s
                    <span class="text-gray-400">
                        ({{ project.name }})
                    </span>
                </h3>
                <p class="text-sm text-gray-400">
                    {{ user.name }} #{{ project.id }} updated {{ updatedAt }}
                </p>
            </div>
        </div>

        <!-- Right Content -->
        <div class="flex items-center space-x-3">
            <span class="px-2 py-1 text-sm text-gray-300 bg-gray-700 rounded"
                >
                {{ project.visibility }}
            </span
            >
<!--            <button class="text-gray-400 hover:text-white">-->
<!--                <svg-->
<!--                    xmlns="http://www.w3.org/2000/svg"-->
<!--                    fill="none"-->
<!--                    viewBox="0 0 24 24"-->
<!--                    stroke="currentColor"-->
<!--                    class="w-5 h-5"-->
<!--                >-->
<!--                    <path-->
<!--                        stroke-linecap="round"-->
<!--                        stroke-linejoin="round"-->
<!--                        stroke-width="2"-->
<!--                        d="M6 10h12M6 14h12m-7 4h7M5 18H4m1-8H4m1-4H4"-->
<!--                    />-->
<!--                </svg>-->
<!--            </button>-->
        </div>
    </div>
</template>
