<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CommentSection from "@/Components/CommentSection.vue";
import {computed} from "vue";
import {formatDistanceToNow} from "date-fns";
import DimedLabel from "@/Components/DimedLabel.vue";
import {Link, useForm} from "@inertiajs/vue3";
import Heading from "@/Components/Heading.vue";
// import ActivityLog from "@/Components/ActivityLog.vue";

const props = defineProps({
    project: Object,
    issue: Object,
    comments: Object,
});

// Initialize the form
const form = useForm({
    content: '',
});

// Handle form submission
const submitForm = () => {
    form.post(route('comment.store', {project: props.project.id, issue: props.issue.id}), {
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};
const updatedAt = computed(() => {
    return formatDistanceToNow(new Date(props.issue.updated_at), {addSuffix: true});
})

</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[
                    { label: 'Projects', link: '/projects' },
                    { label: props.project.name, link: '/projects/' + props.project.id },
                    { label: 'Issues', link: '/project/' + props.project.id },
                    { label: props.issue.title, link: '/projects/' + props.project.id + '/issues/' + props.issue.id },
                 ]"
                heading=""
            />
            <div class="flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6 mt-10">
                <!-- Main Section -->
                <div class="flex-1 space-y-6">
                    <!-- Header -->
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">
                                {{ issue.title }} <span class="text-gray-400">#{{ issue.id }}</span>
                            </h1>
                            <p class="text-sm text-gray-400">
                                {{ issue.creator.name }} {{ issue.status === 'open' ? 'Opened' : 'Closed' }} this issue
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
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                :href="route('issue.edit', { project: props.project.id, issue: props.issue.id })"
                            >
                                Edit
                            </Link>
                        </div>
                    </div>

                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h2 class="text-lg font-bold text-white">Description</h2>
                        <p class="text-gray-300">{{ issue.description }}</p>
                    </div>

                    <h2 class="text-lg font-bold text-white">Comments</h2>
                    <div class="">
                        <CommentSection :comments="issue.comments"/>
                    </div>

                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h2 class="text-lg font-bold text-white">Add Comment</h2>
                        <form @submit.prevent="submitForm">
                        <textarea name="content" v-model="form.content" id="content"
                                  class="w-full h-24 bg-gray-700 text-gray-300 p-4 rounded-lg"
                                  placeholder="Enter your comment here"></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-blue-700 text-white rounded-md">Add Comment
                            </button>
                        </form>
                    </div>

                    <!-- Activity Log -->
                    <!--                <div class="bg-gray-800 p-4 rounded-lg">-->
                    <!--                    <ActivityLog :logs="issue.activity_logs" />-->
                    <!--                </div>-->
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3 space-y-4">
                    <!-- Assignees -->
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h2 class="text-lg font-bold text-white">Assignees</h2>
                        <ul>
                            <li v-for="user in issue.assignees" :key="user.id" class="text-gray-300">
                                {{ user.name }}
                            </li>
                        </ul>
                    </div>

                    <!-- Labels -->
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h2 class="text-lg font-bold text-white">Labels</h2>
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

                    <!-- Other Sidebar Items -->
                    <!-- Add similar sections for Projects, Milestones, etc. -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
