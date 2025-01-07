<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Heading from "@/Components/Heading.vue";
import AddUserToProjectModal from "@/Components/AddUserToProjectModal.vue";
import EditUserRoleModal from "@/Components/EditUserRoleModal.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    users: {
        type: Object,
    },
    roles: {
        type: Object,
    },
});
</script>

<template>
    <Head title="User Role Management" />

    <AuthenticatedLayout>
        <div class="min-h-screen">
            <Heading
                :breadcrumbs="[
                    {
                        label: 'Manage Role Assignment',
                        link: '/user-role-management',
                    },
                ]"
                heading="Manage Role Assignment"
            />

            <div class="relative mt-10 overflow-x-auto rounded-lg">
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
                            v-for="user in users.data"
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
                                :key="role.id"
                            >
                                {{ role.name }}
                            </td>
                            <td class="px-6 py-4">
                                <EditUserRoleModal
                                    :user="user"
                                    :roles="roles"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-6" v-if="users.data.length > 10">
                <Pagination :links="users.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
