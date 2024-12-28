<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    project: Object,
    issue: Object,
    comments: Object
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex flex-col lg:flex-row space-y-6 lg:space-y-0 lg:space-x-6">
            <!-- Main Section -->
            <div class="flex-1 space-y-6">
                <!-- Header -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-white">
                            {{ issue.title }} <span class="text-gray-400">#{{ issue.id }}</span>
                        </h1>
                        <p class="text-sm text-gray-400">
<!--                            {{ issue.status === 'open' ? 'Opened' : 'Closed' }} by {{ issue.user.name }}-->
                        </p>
                    </div>
                    <span
                        :class="{
                            'bg-green-500': issue.status === 'open',
                            'bg-gray-600': issue.status === 'closed',
                        }"
                        class="px-3 py-1 text-white rounded-full"
                    >
                        {{ issue.status }}
                    </span>
                </div>

                <!-- Comments Section -->
                <div v-for="comment in comments" :key="comment.id" class="p-4 border-b border-gray-700">
                    <p class="text-sm text-gray-400">{{ comment.user.name }} commented:</p>
                    <p class="text-gray-200">{{ comment.content }}</p>
                    <p class="text-xs text-gray-500">{{ new Date(comment.created_at).toLocaleString() }}</p>
                </div>

                <!-- Activity Log -->
                <div class="bg-gray-800 p-4 rounded-lg">
<!--                    <ActivityLog :logs="issue.activity_logs" />-->
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3 space-y-4">
                <!-- Assignees -->
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h2 class="text-lg font-bold text-white">Assignees</h2>
                    <ul>
<!--                        <li v-for="user in issue.assignees" :key="user.id" class="text-gray-300">-->
<!--                            {{ user.name }}-->
<!--                        </li>-->
                    </ul>
                </div>

                <!-- Labels -->
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h2 class="text-lg font-bold text-white">Labels</h2>
                    <div class="flex flex-wrap">
                        <span
                            v-for="label in issue.labels"
                            :key="label.id"
                            :style="{ backgroundColor: label.color + '33', color: label.color }"
                            class="px-2 py-1 rounded-full text-sm border mr-2 mb-2"
                        >
                            {{ label.name }}
                        </span>
                    </div>
                </div>

                <!-- Other Sidebar Items -->
                <!-- Add similar sections for Projects, Milestones, etc. -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
