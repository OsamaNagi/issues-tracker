<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    comments: Object,
});

console.log(props.comments);

const toggleDropdown = ref(null);

const toggleDropdownMenu = (index) => {
    toggleDropdown.value = toggleDropdown.value === index ? null : index;
};
</script>

<template>
    <div class="space-y-4">
        <article
            v-for="(comment, index) in comments.data"
            :key="comment.id"
            class="p-6 text-base bg-white rounded-lg dark:bg-gray-800"
        >
            <footer class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <p
                        class="inline-flex items-center mr-3 text-sm font-semibold text-gray-900 dark:text-white"
                    >
                        <img
                            class="w-6 h-6 mr-2 rounded-full"
                            :src="comment.user.avatar"
                            alt="Michael Gough"
                        />
                        @{{ comment.user.name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ new Date(comment.created_at).toLocaleString() }}
                    </p>
                </div>
                <div class="relative">
                    <button
                        @click="toggleDropdownMenu(index)"
                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg dark:text-gray-400 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        type="button"
                    >
                        <svg
                            class="w-4 h-4"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 16 3"
                        >
                            <path
                                d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                            />
                        </svg>
                        <span class="sr-only">Comment settings</span>
                    </button>
                    <!-- Dropdown menu -->
                    <div
                        v-show="toggleDropdown === index"
                        class="absolute z-10 bg-white divide-y divide-gray-100 rounded shadow right-5 top-2 w-36 dark:bg-gray-700 dark:divide-gray-600"
                    >
                        <ul
                            class="py-1 text-sm text-gray-700 dark:text-gray-200"
                        >
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                >Edit</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                >Remove</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
            <p class="dark:text-gray-200">
                {{ comment.content }}
            </p>
            <div class="flex items-center mt-4 space-x-4">
                <button
                    type="button"
                    class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
                >
                    <svg
                        class="mr-1.5 w-3.5 h-3.5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 18"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"
                        />
                    </svg>
                    Reply
                </button>
            </div>
        </article>

        <div >
            <Link
                v-for="link in comments.meta.links"
                :href="link.url"
                v-html="link.label"
                class="px-3 py-1 mx-1.5 w-full text-sm font-medium rounded-md
                     hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                     dark:hover:bg-blue-700 dark:focus:ring-blue-800
                     transition-colors
                     text-white bg-blue-700
                     sm:px-4 sm:py-2"
            />
        </div>
    </div>
</template>
