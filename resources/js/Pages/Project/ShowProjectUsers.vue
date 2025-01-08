<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import AddUserToProjectModal from "@/Components/AddUserToProjectModal.vue";
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import EmptyState from "@/Components/EmptyState.vue";

const props = defineProps({
    project: {
        type: Object,
    },
    projectUsers: {
        type: Object,
    },
    users: {
        type: Object,
    },
});

const form = useForm({
    user_id: "",
});

const projectUsers = reactive(props.projectUsers.data);

const submitForm = (userId) => {
    form.delete(
        route("project.removeUser", {
            project: props.project.id,
            user: userId,
        }),
        {
            onError: (errors) => {
                console.error("Validation errors:", errors);
            },
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen">
            <div class="flex items-center justify-between">
                <p class="text-lg font-bold text-slate-50">
                    Add users to project
                </p>

                <div>
                    <AddUserToProjectModal :users="users" :project="project" />
                </div>
            </div>
            <div v-if="projectUsers.length === 0" class="mt-10 !h-[20rem]">
                <EmptyState> No users found </EmptyState>
            </div>
            <div v-else class="relative mt-10 overflow-x-auto rounded-lg">
                <table
                    class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in projectUsers"
                            :key="user.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <th
                                scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
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
                            </th>
                            <td
                                class="px-6 py-4"
                                v-for="role in user.roles"
                                key="role.id"
                            >
                                {{ role.name }}
                            </td>
                            <td class="px-6 py-4">
                                <form
                                    @submit.prevent="() => submitForm(user.id)"
                                >
                                    <button
                                        type="submit"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                    >
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
