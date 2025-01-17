<script setup>
import EmptyState from "@/Components/EmptyState.vue";
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const page = usePage();

const notificationsCount = computed(() => page.props.notificationsCount);
const notifications = computed(() => page.props.notifications?.data);

const toggleNotification = () => {
    const dropdownNotification = document.getElementById(
        "dropdownNotification"
    );
    dropdownNotification.classList.toggle("hidden");
};

const getNotificationType = (notification) => {
    const type = notification.data.notification_type;

    switch (type) {
        case "added_user_to_project":
            return ` added you to
                            <span class="font-medium text-blue-500">
                                ${notification.data.project_name}
                            </span> project.`;

        case "new_issue_opened":
            return ` opened a new issue in
                            <span class="font-medium text-blue-500">
                                ${notification.data.project_name}
                            </span> ${notification.data.title}.`;

        case "close_project":
            return ` Closed the
                            <span class="font-medium text-blue-500">
                                ${notification.data.project_name}
                            </span> project.`;

        case "reopen_project":
            return ` Reopened the
                            <span class="font-medium text-blue-500">
                                ${notification.data.project_name}
                            </span> project.`;

        case "update_project":
            return ` Updated the
                            <span class="font-medium text-blue-500">
                                ${notification.data.project_name}
                            </span> project.`;

        case "assign_user_to_issue":
            return ` assigned you to the issue
                            <span class="font-medium text-blue-500">
                                ${notification.data.issue_title}
                            </span>.`;

        case "unassign_user_from_issue":
            return ` unassigned you from the issue
                            <span class="font-medium text-blue-500">
                                ${notification.data.issue_title}
                            </span>.`;

        default:
            return "performed an action.";
    }
}

</script>

<template>
    <button
        id="dropdownNotificationButton"
        @click="toggleNotification"
        data-dropdown-toggle="dropdownNotification"
        class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
        type="button"
    >
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 14 20"
        >
            <path
                d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"
            />
        </svg>

        <div
            class="absolute inline-flex items-center justify-center w-5 h-5 text-[9px] font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900"
        >
            {{ notificationsCount }}
        </div>
    </button>

    <!-- Dropdown menu -->
    <div
        id="dropdownNotification"
        class="absolute z-20 hidden w-full max-w-sm bg-white border divide-y divide-gray-100 rounded-lg shadow-md top-10 right-20 dark:bg-gray-800 dark:divide-gray-700 dark:border-gray-700"
        aria-labelledby="dropdownNotificationButton"
    >
        <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white"
        >
            Notifications
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            <div class="py-4" v-if="notificationsCount === 0">
                <EmptyState>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        No new notifications
                    </div>
                </EmptyState>
            </div>
            <div v-else>
                <a
                    v-for="notification in notifications"
                    :key="notification.id"
                    href="#"
                    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <div class="flex-shrink-0">
                        <img
                            class="rounded-full w-11 h-11"
                            :src="notification.data.user_avatar"
                            alt="Leslie image"
                        />
                        <div
                            class="absolute flex items-center justify-center w-5 h-5 -mt-5 bg-green-400 border border-white rounded-full ms-6 dark:border-gray-800"
                        >
                            <svg
                                class="w-2 h-2 text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 18"
                            >
                                <path
                                    d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="w-full ps-3">
                        <div
                            class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"
                        >
                            <span
                                class="font-semibold text-gray-900 dark:text-white"
                            >
                                @{{ notification.data.created_by }}
                            </span>
                            <!--                            opened a new issue in-->
                            <!--                            <span class="font-medium text-blue-500" href="#">-->
                            <!--                                {{ notification.data.project_name }}-->
                            <!--                            </span>-->
                            <!--                            {{ notification.data.title }}-->

                            <span v-html="getNotificationType(notification)"></span>

                        </div>
                        <div class="text-xs text-blue-600 dark:text-blue-500">
                            {{ notification.created_at_human }}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <a
            href="#"
            class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white"
        >
            <div class="inline-flex items-center">
                <svg
                    class="w-4 h-4 text-gray-500 me-2 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 14"
                >
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"
                    />
                </svg>
                View all
            </div>
        </a>
    </div>
</template>
