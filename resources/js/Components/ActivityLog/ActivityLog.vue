<script setup>
import { formatDistanceToNow } from "date-fns";
import CommentLog from "./CommentLog.vue";
import IssueStatusLog from "./IssueStatusLog.vue";
import IssueEditedLog from "./IssueEditedLog.vue";

const props = defineProps({
    activityLog: Object,
});
</script>

<template>
    <ol class="relative border-gray-200 border-s dark:border-gray-700">
        <li class="mb-10 ms-6" v-for="log in activityLog" :key="log.id">
            <span
                class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900"
            >
                <img
                    class="rounded-full shadow-lg"
                    :src="log.causer.avatar"
                    alt=""
                />
            </span>

            <CommentLog :log="log" v-if="log.log_name === 'comment'" />

            <IssueStatusLog
                :log="log"
                v-else-if="
                    log.log_name === 'close_issue' ||
                    log.log_name === 'reopen_issue'
                "
            />

            <IssueEditedLog :log="log" v-else />
        </li>
    </ol>
</template>
