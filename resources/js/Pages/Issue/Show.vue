<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CommentSection from "@/Components/CommentSection.vue";
import { computed, reactive, ref } from "vue";
import { formatDistanceToNow } from "date-fns";
import DimedLabel from "@/Components/DimedLabel.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
import DeleteIssueModal from "@/Components/DeleteIssueModal.vue";
import ActivityLog from "@/Components/ActivityLog.vue";

const props = defineProps({
    project: Object,
    issue: Object,
    comments: Object,
    assignees: Object,
    activityLog: Object,
});

const showDeleteModal = ref(false);

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

// Function to handle the modal close
const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const assignees = reactive(props.assignees.data);

// Initialize the form
const form = useForm({
    content: "",
});

// Handle form submission
const submitForm = () => {
    form.post(
        route("comment.store", {
            project: props.project.id,
            issue: props.issue.id,
        }),
        {
            onError: (errors) => {
                console.error("Validation errors:", errors);
            },
        }
    );
};
const updatedAt = computed(() => {
    return formatDistanceToNow(new Date(props.issue.updated_at), {
        addSuffix: true,
    });
});

const issueStatusForm = useForm({});

const toggleIssueStatus = () => {
    const action = props.issue.status === "open" ? "close" : "reopen";

    issueStatusForm.patch(
        route(`issue.${action}`, {
            project: props.project.id,
            issue: props.issue.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                // Update issue status locally
                props.issue.status = action === "close" ? "closed" : "open";
            },
            onError: (errors) => {
                console.error(`Error ${action}ing issue:`, errors);
            },
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[
                    { label: 'Projects', link: '/projects' },
                    {
                        label: props.project.name,
                        link: '/projects/' + props.project.id,
                    },
                    { label: 'Issues', link: '/project/' + props.project.id },
                    {
                        label: props.issue.title,
                        link:
                            '/projects/' +
                            props.project.id +
                            '/issues/' +
                            props.issue.id,
                    },
                ]"
                heading="Issue Details"
            />
            <div
                class="flex flex-col mt-10 space-y-6 lg:flex-row lg:space-y-0 lg:space-x-6"
            >
                <!-- Main Section -->
                <div class="flex-1 space-y-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h1
                                class="text-2xl font-bold text-gray-900 dark:text-gray-50"
                            >
                                {{ issue.title }}
                                <span class="text-gray-400"
                                    >#{{ issue.id }}</span
                                >
                            </h1>
                            <p class="text-sm text-gray-400">
                                {{ issue.creator.name }}
                                {{
                                    issue.status === "open"
                                        ? "Opened"
                                        : "Closed"
                                }}
                                this issue
                                {{ updatedAt }}
                            </p>
                        </div>
                        <div class="flex gap-x-2">
                            <span
                                :class="{
                                    'bg-green-500': issue.status === 'open',
                                    'bg-indigo-600': issue.status === 'closed',
                                }"
                                class="px-3 py-1 text-white rounded-full"
                            >
                                {{ issue.status }}
                            </span>
                            <Link
                                v-if="issue.canEdit"
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                :href="
                                    route('issue.edit', {
                                        project: props.project.id,
                                        issue: props.issue.id,
                                    })
                                "
                            >
                                Edit
                            </Link>
                        </div>
                    </div>

                    <div class="p-4 bg-white rounded-lg dark:bg-gray-800">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Description
                        </h2>
                        <p class="text-gray-900 dark:text-gray-300">
                            {{ issue.description }}
                        </p>
                    </div>

                    <!-- Activity Log -->
                    <div class="px-4">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Activity Log
                        </h2>
                        <div class="mt-8">
                            <ActivityLog :activityLog="activityLog" />
                        </div>
                    </div>

                    <div class="p-4 bg-white rounded-lg dark:bg-gray-800">
                        <div class="flex items-center justify-between mb-6">
                            <h2
                                class="text-lg font-bold text-gray-900 lg:text-2xl dark:text-white"
                            >
                                Add Discussion
                            </h2>
                        </div>
                        <form @submit.prevent="submitForm">
                            <div
                                class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg dark:bg-gray-800 dark:border-gray-700"
                            >
                                <label for="content" class="sr-only"
                                    >Your comment</label
                                >
                                <textarea
                                    name="content"
                                    v-model="form.content"
                                    id="content"
                                    rows="2"
                                    class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                                    placeholder="Write a comment..."
                                    required
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                class="px-4 py-2 mt-2 text-white bg-blue-700 rounded-md"
                            >
                                Post comment
                            </button>
                        </form>
                    </div>

                    <!-- <div class="">
                        <CommentSection :comments="comments" />
                    </div> -->
                </div>

                <!-- Sidebar -->
                <div class="w-full space-y-4 lg:w-1/3">
                    <!-- close issue -->
                    <div
                        v-if="issue.canEdit"
                        class="p-4 bg-white rounded-lg dark:bg-gray-800"
                    >
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Issue Status
                        </h2>

                        <div class="flex mt-2">
                            <button
                                type="button"
                                @click="toggleIssueStatus"
                                :disabled="issueStatusForm.processing"
                                :class="[
                                    'bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-4 font-bold rounded-md whitespace-nowrap text-xs md:text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 border',

                                    issue.status === 'open'
                                        ? 'text-indigo-600 border-indigo-600 focus:ring-indigo-600 dark:focus:ring-indigo-600'
                                        : 'text-green-500 border-green-500 focus:ring-green-500 dark:focus:ring-green-500',
                                ]"
                            >
                                <span v-if="issueStatusForm.processing"
                                    >Processing...</span
                                >
                                <span
                                    v-else
                                    class="flex items-center justify-center"
                                >
                                    <svg
                                        v-if="issue.status === 'open'"
                                        class="w-6 h-6 mr-2 text-indigo-600"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>

                                    <svg
                                        v-else
                                        class="w-6 h-6 mr-2 text-green-500"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke="currentColor"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"
                                        />
                                    </svg>

                                    {{
                                        issue.status === "open"
                                            ? "Close this issue"
                                            : "Reopen this issue"
                                    }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Assignees -->
                    <div class="p-4 bg-white rounded-lg dark:bg-gray-800">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Assignees
                        </h2>
                        <ul>
                            <li
                                v-for="user in assignees"
                                :key="user.id"
                                class="flex items-center px-2 py-2 text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                <img
                                    class="w-10 h-10 rounded-full"
                                    :src="user.avatar"
                                    alt="Jese image"
                                />
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        {{ user.name }}
                                    </div>
                                    <div class="font-normal text-gray-500">
                                        {{ user.email }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Labels -->
                    <div class="p-4 bg-white rounded-lg dark:bg-gray-800">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Labels
                        </h2>
                        <div class="flex flex-wrap mt-2 space-x-2">
                            <DimedLabel
                                v-for="label in issue.labels"
                                :key="label"
                                :Color="label.color"
                            >
                                {{ label.name }}
                            </DimedLabel>
                        </div>
                    </div>

                    <!-- danger zone -->
                    <div
                        v-if="issue.canEdit"
                        class="p-4 bg-white rounded-lg dark:bg-gray-800"
                    >
                        <h2
                            class="text-lg font-bold text-red-600 dark:text-red-500"
                        >
                            Danger Zone
                        </h2>

                        <div class="flex mt-2">
                            <DeleteIssueModal
                                :project="project"
                                :issue="issue"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
